<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class LiquorGuardController extends Controller
{
    // ─── Table Resolvers ──────────────────────────────────────────────────────

    private function getTable($name)
    {
        $lgName = 'lg_' . $name;
        if (Schema::hasTable($lgName)) {
            return DB::table($lgName);
        }
        if (Schema::hasTable($name)) {
            return DB::table($name);
        }
        return DB::table($lgName);
    }

    private function logAudit($userId, $action, $details = '')
    {
        try {
            $this->getTable('audit_logs')->insert([
                'user_id'    => $userId,
                'action'     => $action,
                'details'    => $details,
                'ip_address' => request()->ip(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {}
    }

    // ─── Views ────────────────────────────────────────────────────────────────

    public function login()
    {
        if (session('lg_user_id')) {
            return in_array(session('lg_role'), ['superadmin', 'admin']) 
                ? redirect('/liquorguard/admin') 
                : redirect('/liquorguard');
        }
        return view('liquorguard.login');
    }

    public function logout(Request $request)
    {
        $userId = session('lg_user_id');
        if ($userId) {
            $this->logAudit($userId, 'LOGOUT', 'Cierre de sesión');
        }
        session()->forget(['lg_user_id', 'lg_role', 'lg_name', 'lg_business', 'lg_email', 'lg_min_age', 'lg_can_change_age', 'lg_days']);
        return redirect('/liquorguard/login');
    }

    public function index()
    {
        if (!session('lg_user_id')) {
            return redirect('/liquorguard/login');
        }
        return view('liquorguard.index');
    }

    public function admin()
    {
        if (!session('lg_user_id')) {
            return redirect('/liquorguard/login');
        }
        if (!in_array(session('lg_role'), ['superadmin', 'admin'])) {
            return redirect('/liquorguard');
        }
        return view('liquorguard.admin');
    }

    // ─── Auth API ─────────────────────────────────────────────────────────────

    public function apiLogin(Request $request)
    {
        $raw = json_decode($request->getContent(), true) ?: [];
        $email = trim((string)($request->input('email') ?: ($raw['email'] ?? '')));
        $password = (string)($request->input('password') ?: ($raw['password'] ?? ''));

        if ($email === '' || $password === '') {
            return response()->json([
                'success' => false,
                'message' => 'Por favor ingrese correo y contraseña.',
            ], 400);
        }

        try {
            $user = $this->getTable('users')
                ->where(function ($q) use ($email) {
                    $q->where('email', $email)
                      ->orWhere('email', 'LIKE', $email . '@%')
                      ->orWhere('email', 'LIKE', '%' . $email . '%');
                })
                ->first();

            if (!$user || !Hash::check($password, $user->password_hash)) {
                $this->logAudit($user->id ?? null, 'LOGIN_FAILED', "Intento fallido para: $email");
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas. Verifique su correo o contraseña.',
                ], 401);
            }

            if ($user->status === 'suspended') {
                $this->logAudit($user->id, 'LOGIN_BLOCKED', 'Cuenta suspendida intentó ingresar');
                return response()->json([
                    'success' => false,
                    'message' => 'Su cuenta se encuentra suspendida. Contacte al administrador.',
                    'status'  => 'suspended',
                ], 403);
            }

            if ($user->role !== 'superadmin') {
                $expires = new \DateTime($user->subscription_expires_at);
                $now     = new \DateTime();
                if ($now > $expires || $user->status === 'expired') {
                    $this->getTable('users')->where('id', $user->id)->update(['status' => 'expired']);
                    $this->logAudit($user->id, 'LOGIN_BLOCKED', 'Cuenta con suscripción vencida');
                    return response()->json([
                        'success'    => false,
                        'message'    => 'Su suscripción ha vencido el ' . $expires->format('d/m/Y') . '.',
                        'status'     => 'expired',
                        'expired_at' => $expires->format('d/m/Y'),
                    ], 403);
                }
            }

            $userName = $user->contact_name ?: ($user->business_name ?: $user->email);

            // Store session
            session([
                'lg_user_id'        => $user->id,
                'lg_role'           => $user->role,
                'lg_name'           => $userName,
                'lg_business'       => $user->business_name,
                'lg_email'          => $user->email,
                'lg_min_age'        => $user->custom_min_age ?? 18,
                'lg_can_change_age' => (bool) ($user->can_change_min_age ?? false),
                'lg_days'           => max(0, (int) round((strtotime($user->subscription_expires_at) - time()) / 86400)),
            ]);

            // Update last login
            $this->getTable('users')
                ->where('id', $user->id)
                ->update(['last_login' => now()]);

            $this->logAudit($user->id, 'LOGIN_SUCCESS', 'Inicio de sesión exitoso');

            $redirect = in_array($user->role, ['superadmin', 'admin']) ? '/liquorguard/admin' : '/liquorguard';

            return response()->json([
                'success'  => true,
                'message'  => 'Inicio de sesión exitoso.',
                'redirect' => $redirect,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de servidor: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function apiLogout(Request $request)
    {
        $userId = session('lg_user_id');
        if ($userId) {
            $this->logAudit($userId, 'LOGOUT', 'Cierre de sesión');
        }
        session()->forget(['lg_user_id', 'lg_role', 'lg_name', 'lg_business', 'lg_email', 'lg_min_age', 'lg_can_change_age', 'lg_days']);
        return response()->json(['success' => true, 'redirect' => '/liquorguard/login']);
    }

    // ─── Scans API ────────────────────────────────────────────────────────────

    public function apiScanRecord(Request $request)
    {
        if (!session('lg_user_id')) {
            return response()->json(['success' => false, 'message' => 'No autenticado.'], 401);
        }

        $raw = json_decode($request->getContent(), true) ?: [];
        $age = $request->input('age') ?: ($raw['age'] ?? null);
        $gender = $request->input('gender') ?: ($raw['gender'] ?? 'Unknown');
        $verdict = $request->input('verdict') ?: ($raw['verdict'] ?? 'CHECK_ID');
        $confidence = $request->input('confidence') ?: ($raw['confidence'] ?? 0.95);

        try {
            $this->getTable('scans_history')->insert([
                'user_id'       => session('lg_user_id'),
                'age_estimated' => $age,
                'gender'        => $gender,
                'verdict'       => $verdict,
                'confidence'    => $confidence,
                'created_at'    => now(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiScanHistory(Request $request)
    {
        if (!session('lg_user_id')) {
            return response()->json(['success' => false, 'message' => 'No autenticado.'], 401);
        }

        $limit = (int) $request->get('limit', 20);

        try {
            $scans = $this->getTable('scans_history')
                ->where('user_id', session('lg_user_id'))
                ->orderByDesc('id')
                ->limit($limit)
                ->get()
                ->map(fn($s) => array_merge((array)$s, [
                    'formatted_time' => \Carbon\Carbon::parse($s->created_at)->format('H:i:s - d/m/Y'),
                ]));

            $metrics = $this->getTable('scans_history')
                ->where('user_id', session('lg_user_id'))
                ->selectRaw('COUNT(*) as total_scans,
                    SUM(CASE WHEN verdict = "ALLOWED"  THEN 1 ELSE 0 END) as allowed_count,
                    SUM(CASE WHEN verdict = "REJECTED" THEN 1 ELSE 0 END) as rejected_count,
                    SUM(CASE WHEN verdict = "CHECK_ID" THEN 1 ELSE 0 END) as check_id_count,
                    AVG(age_estimated) as avg_age')
                ->first();

            return response()->json([
                'success' => true,
                'history' => $scans,
                'metrics' => [
                    'total'    => (int) ($metrics->total_scans ?? 0),
                    'allowed'  => (int) ($metrics->allowed_count ?? 0),
                    'rejected' => (int) ($metrics->rejected_count ?? 0),
                    'check_id' => (int) ($metrics->check_id_count ?? 0),
                    'avg_age'  => round((float) ($metrics->avg_age ?? 0), 1),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─── Admin APIs ───────────────────────────────────────────────────────────

    private function ensureAdmin()
    {
        if (!session('lg_user_id') || !in_array(session('lg_role'), ['superadmin', 'admin'])) {
            return response()->json(['success' => false, 'message' => 'Acceso denegado. Se requieren permisos de Administrador.'], 403);
        }
        return null;
    }

    public function apiAdminMetrics()
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        try {
            $totalClients = $this->getTable('users')->where('role', '!=', 'superadmin')->count();
            $activeClients = $this->getTable('users')->where('role', '!=', 'superadmin')->where('status', 'active')->where('subscription_expires_at', '>', now())->count();
            $expiredClients = $this->getTable('users')->where('role', '!=', 'superadmin')->where(function($q) {
                $q->where('status', 'expired')->orWhere('subscription_expires_at', '<=', now());
            })->count();
            $suspendedClients = $this->getTable('users')->where('role', '!=', 'superadmin')->where('status', 'suspended')->count();
            
            $sevenDaysFromNow = (new \DateTime())->modify('+7 day')->format('Y-m-d H:i:s');
            $expiringSoon = $this->getTable('users')->where('role', '!=', 'superadmin')
                ->where('status', 'active')
                ->where('subscription_expires_at', '>', now())
                ->where('subscription_expires_at', '<=', $sevenDaysFromNow)
                ->count();

            $totalScans = $this->getTable('scans_history')->count();

            return response()->json([
                'success' => true,
                'metrics' => [
                    'total_clients'     => $totalClients,
                    'active_clients'    => $activeClients,
                    'expiring_soon'     => $expiringSoon,
                    'suspended_clients' => $suspendedClients,
                    'expired_clients'   => $expiredClients,
                    'total_scans'       => $totalScans,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiAdminClients(Request $request)
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        $status = $request->get('status', 'all');
        $search = trim($request->get('search', ''));

        try {
            $query = $this->getTable('users')->where('id', '!=', session('lg_user_id'))->orderByDesc('id');

            if ($status !== 'all') {
                if ($status === 'active') {
                    $query->where('status', 'active')->where('subscription_expires_at', '>', now());
                } elseif ($status === 'expired') {
                    $query->where(function($q) {
                        $q->where('status', 'expired')->orWhere('subscription_expires_at', '<=', now());
                    });
                } elseif ($status === 'suspended') {
                    $query->where('status', 'suspended');
                }
            }

            if ($search !== '') {
                $query->where(function($q) use ($search) {
                    $q->where('business_name', 'like', "%{$search}%")
                      ->orWhere('contact_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Get scan counts grouped by user_id
            $scanCounts = $this->getTable('scans_history')
                ->selectRaw('user_id, count(*) as count')
                ->groupBy('user_id')
                ->pluck('count', 'user_id');

            $clients = $query->get()->map(function($c) use ($scanCounts) {
                $expires = new \DateTime($c->subscription_expires_at);
                $now = new \DateTime();
                $diff = $now->diff($expires);
                $daysRemaining = ($now > $expires) ? -$diff->days : $diff->days;
                $created = $c->created_at ? new \DateTime($c->created_at) : new \DateTime();

                return [
                    'id'                      => $c->id,
                    'business_name'           => $c->business_name,
                    'contact_name'            => $c->contact_name ?: $c->business_name,
                    'email'                   => $c->email,
                    'role'                    => $c->role ?? 'client',
                    'status'                  => ($c->status === 'suspended') ? 'suspended' : (($now > $expires) ? 'expired' : 'active'),
                    'subscription_expires_at' => $c->subscription_expires_at,
                    'formatted_expires'       => $expires->format('d/m/Y'),
                    'formatted_created'       => $created->format('d/m/Y'),
                    'days_left'               => $daysRemaining,
                    'days_remaining'          => $daysRemaining,
                    'months_purchased'        => $c->months_purchased ?? 1,
                    'total_scans'             => (int)($scanCounts[$c->id] ?? 0),
                    'can_export_reports'      => (bool)($c->can_export_reports ?? false),
                    'can_change_min_age'      => (bool)($c->can_change_min_age ?? false),
                    'can_view_logs'           => (bool)($c->can_view_logs ?? true),
                    'custom_min_age'          => $c->custom_min_age ?? 18,
                    'language'                => $c->language ?? 'es',
                    'last_login'              => $c->last_login ? date('d/m/Y H:i', strtotime($c->last_login)) : 'Nunca',
                ];
            });

            return response()->json(['success' => true, 'clients' => $clients]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiAdminCreateClient(Request $request)
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        $raw = json_decode($request->getContent(), true) ?: [];
        $businessName = trim((string)($request->input('business_name') ?: ($raw['business_name'] ?? '')));
        $contactName  = trim((string)($request->input('contact_name') ?: ($raw['contact_name'] ?? '')));
        $email        = trim((string)($request->input('email') ?: ($raw['email'] ?? '')));
        $password     = (string)($request->input('password') ?: ($raw['password'] ?? ''));
        $role         = in_array($request->input('role') ?: ($raw['role'] ?? 'client'), ['admin', 'client']) ? ($request->input('role') ?: ($raw['role'] ?? 'client')) : 'client';
        $language     = in_array($request->input('language') ?: ($raw['language'] ?? 'es'), ['es', 'en']) ? ($request->input('language') ?: ($raw['language'] ?? 'es')) : 'es';
        $months       = max(1, (int)($request->input('months_purchased') ?: ($request->input('months') ?: ($raw['months_purchased'] ?? ($raw['months'] ?? 1)))));
        $canExport    = !empty($request->input('can_export_reports') ?: ($raw['can_export_reports'] ?? false)) ? 1 : 0;
        $canChangeAge = !empty($request->input('can_change_min_age') ?: ($raw['can_change_min_age'] ?? false)) ? 1 : 0;
        $canViewLogs  = !empty($request->input('can_view_logs') ?: ($raw['can_view_logs'] ?? true)) ? 1 : 0;

        if (empty($businessName) || empty($email) || empty($password)) {
            return response()->json(['success' => false, 'message' => 'Por favor complete todos los campos obligatorios.'], 400);
        }

        try {
            $existing = $this->getTable('users')->where('email', $email)->first();
            if ($existing) {
                return response()->json(['success' => false, 'message' => 'Ya existe una cuenta con este correo electrónico.'], 400);
            }

            $expiresAt = (new \DateTime())->modify("+{$months} month");
            $expiresAtStr = $expiresAt->format('Y-m-d H:i:s');
            $passwordHash = Hash::make($password);

            $newId = $this->getTable('users')->insertGetId([
                'business_name'           => $businessName,
                'contact_name'            => $contactName,
                'email'                   => $email,
                'password_hash'           => $passwordHash,
                'role'                    => $role,
                'status'                  => 'active',
                'subscription_expires_at' => $expiresAtStr,
                'months_purchased'        => $months,
                'can_export_reports'      => $canExport,
                'can_change_min_age'      => $canChangeAge,
                'can_view_logs'           => $canViewLogs,
                'custom_min_age'          => 18,
                'language'                => $language,
                'created_at'              => now(),
            ]);

            $roleLabel = ($role === 'admin') ? 'Administrador' : 'Cliente';
            $this->logAudit(session('lg_user_id'), 'USER_CREATED', "Nuevo $roleLabel #$newId ($businessName) creado por $months meses");

            $loginUrl = url('/liquorguard/login');
            $whatsappMsg = "🛡️ *BIENVENIDO A LIQUORGUARD AI*\n\n"
                . "Hola *{$contactName}*, tu cuenta ($roleLabel) para *{$businessName}* ha sido creada exitosamente.\n\n"
                . "🔑 *Tus datos de acceso:*\n"
                . "🌐 *Enlace:* {$loginUrl}\n"
                . "📧 *Usuario:* {$email}\n"
                . "🔒 *Contraseña:* {$password}\n"
                . "📅 *Vencimiento:* {$expiresAt->format('d/m/Y')} ({$months} meses)\n\n"
                . "Guarda este mensaje. ¡Gracias por tu compra!";

            return response()->json([
                'success'          => true,
                'message'          => "$roleLabel $businessName creado exitosamente por $months meses.",
                'client_id'        => $newId,
                'login_url'        => $loginUrl,
                'expires_at'       => $expiresAtStr,
                'whatsapp_message' => $whatsappMsg,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al crear: ' . $e->getMessage()], 500);
        }
    }

    public function apiAdminRenew(Request $request)
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        $raw = json_decode($request->getContent(), true) ?: [];
        $clientId = (int)($request->input('client_id') ?: ($raw['client_id'] ?? 0));
        $monthsToAdd = max(1, (int)($request->input('months') ?: ($raw['months'] ?? 1)));

        try {
            $client = $this->getTable('users')->where('id', $clientId)->first();
            if (!$client) {
                return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
            }

            $currentExpires = new \DateTime($client->subscription_expires_at);
            $now = new \DateTime();
            $baseDate = ($currentExpires > $now) ? $currentExpires : $now;
            $newExpires = (clone $baseDate)->modify("+{$monthsToAdd} month");
            $newExpiresStr = $newExpires->format('Y-m-d H:i:s');

            $this->getTable('users')->where('id', $clientId)->update([
                'subscription_expires_at' => $newExpiresStr,
                'status'                  => 'active',
                'months_purchased'        => ($client->months_purchased ?? 0) + $monthsToAdd,
            ]);

            $this->logAudit(session('lg_user_id'), 'USER_RENEWED', "Usuario {$client->business_name} renovado por $monthsToAdd meses hasta $newExpiresStr");

            $formattedExp = $newExpires->format('d/m/Y');
            $whatsappMsg = "✅ *RENOVACIÓN EXITOSA - LIQUORGUARD AI*\n\n"
                . "Hola *{$client->contact_name}*, tu suscripción para *{$client->business_name}* ha sido renovada por *{$monthsToAdd} Mes(es)*.\n"
                . "📅 *Nueva fecha de vencimiento:* {$formattedExp}\n"
                . "¡Tu escáner facial continúa activo sin interrupciones!";

            return response()->json([
                'success'           => true,
                'message'           => "Renovación exitosa hasta el $formattedExp (+ $monthsToAdd meses).",
                'new_expires_at'    => $newExpiresStr,
                'formatted_expires' => $formattedExp,
                'whatsapp_message'  => $whatsappMsg,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiAdminUpdatePowers(Request $request)
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        $raw = json_decode($request->getContent(), true) ?: [];
        $clientId     = (int)($request->input('client_id') ?: ($raw['client_id'] ?? 0));
        $canExport    = !empty($request->input('can_export_reports') ?: ($raw['can_export_reports'] ?? false)) ? 1 : 0;
        $canChangeAge = !empty($request->input('can_change_min_age') ?: ($raw['can_change_min_age'] ?? false)) ? 1 : 0;
        $canViewLogs  = !empty($request->input('can_view_logs') ?: ($raw['can_view_logs'] ?? true)) ? 1 : 0;
        $language     = in_array($request->input('language') ?: ($raw['language'] ?? 'es'), ['es', 'en']) ? ($request->input('language') ?: ($raw['language'] ?? 'es')) : 'es';

        try {
            $this->getTable('users')->where('id', $clientId)->update([
                'can_export_reports' => $canExport,
                'can_change_min_age' => $canChangeAge,
                'can_view_logs'      => $canViewLogs,
                'language'           => $language,
            ]);

            $this->logAudit(session('lg_user_id'), 'POWERS_UPDATED', "Poderes actualizados para usuario #$clientId");

            return response()->json(['success' => true, 'message' => 'Permisos y poderes actualizados correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiAdminToggleStatus(Request $request)
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        $raw = json_decode($request->getContent(), true) ?: [];
        $clientId  = (int)($request->input('client_id') ?: ($raw['client_id'] ?? 0));
        $newStatus = trim((string)($request->input('status') ?: ($raw['status'] ?? '')));

        if (!in_array($newStatus, ['active', 'suspended', 'expired'])) {
            return response()->json(['success' => false, 'message' => 'Estado inválido.'], 400);
        }

        try {
            $this->getTable('users')->where('id', $clientId)->update(['status' => $newStatus]);
            $this->logAudit(session('lg_user_id'), 'STATUS_CHANGED', "Usuario #$clientId cambiado a estado $newStatus");

            return response()->json(['success' => true, 'message' => "Estado actualizado a: $newStatus", 'status' => $newStatus]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiAdminResetPassword(Request $request)
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        $raw = json_decode($request->getContent(), true) ?: [];
        $clientId    = (int)($request->input('client_id') ?: ($raw['client_id'] ?? 0));
        $newPassword = trim((string)($request->input('new_password') ?: ($raw['new_password'] ?? '')));

        if ($clientId <= 0 || empty($newPassword)) {
            return response()->json(['success' => false, 'message' => 'Debe ingresar la nueva contraseña.'], 400);
        }

        try {
            $hash = Hash::make($newPassword);
            $this->getTable('users')->where('id', $clientId)->update(['password_hash' => $hash]);
            $this->logAudit(session('lg_user_id'), 'PASSWORD_RESET', "Contraseña restablecida para usuario #$clientId");

            return response()->json(['success' => true, 'message' => 'Contraseña restablecida exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function apiAdminDelete(Request $request)
    {
        if ($deny = $this->ensureAdmin()) return $deny;

        $raw = json_decode($request->getContent(), true) ?: [];
        $clientId = (int)($request->input('client_id') ?: ($raw['client_id'] ?? 0));

        if ($clientId === (int)session('lg_user_id')) {
            return response()->json(['success' => false, 'message' => 'No puedes eliminar tu propia cuenta actual.'], 400);
        }

        try {
            $this->getTable('users')->where('id', $clientId)->delete();
            $this->getTable('scans_history')->where('user_id', $clientId)->delete();
            $this->logAudit(session('lg_user_id'), 'USER_DELETED', "Usuario #$clientId eliminado definitivamente");

            return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
