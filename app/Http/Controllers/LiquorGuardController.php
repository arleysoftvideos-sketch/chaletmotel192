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

    // ─── Views ────────────────────────────────────────────────────────────────

    public function login()
    {
        if (session('lg_user_id')) {
            return redirect('/liquorguard');
        }
        return view('liquorguard.login');
    }

    public function index()
    {
        if (!session('lg_user_id')) {
            return redirect('/liquorguard/login');
        }
        return view('liquorguard.index');
    }

    // ─── Auth API ─────────────────────────────────────────────────────────────

    public function apiLogin(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            $user = $this->getTable('users')
                ->where('email', $data['email'])
                ->first();

            if (!$user || !Hash::check($data['password'], $user->password_hash)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Credenciales inválidas. Verifique su correo o contraseña.',
                ], 401);
            }

            if ($user->status === 'suspended') {
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
                    return response()->json([
                        'success'    => false,
                        'message'    => 'Su suscripción ha vencido el ' . $expires->format('d/m/Y') . '.',
                        'status'     => 'expired',
                        'expired_at' => $expires->format('d/m/Y'),
                    ], 403);
                }
            }

            // Store session
            session([
                'lg_user_id'        => $user->id,
                'lg_role'           => $user->role,
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

            $redirect = ($user->role === 'superadmin') ? '/liquorguard' : '/liquorguard';

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
        session()->forget(['lg_user_id', 'lg_role', 'lg_business', 'lg_email', 'lg_min_age', 'lg_can_change_age', 'lg_days']);
        return response()->json(['success' => true, 'redirect' => '/liquorguard/login']);
    }

    // ─── Scans API ────────────────────────────────────────────────────────────

    public function apiScanRecord(Request $request)
    {
        if (!session('lg_user_id')) {
            return response()->json(['success' => false, 'message' => 'No autenticado.'], 401);
        }

        $data = $request->validate([
            'age'        => 'required|numeric',
            'gender'     => 'nullable|string|max:20',
            'verdict'    => 'required|in:ALLOWED,REJECTED,CHECK_ID',
            'confidence' => 'nullable|numeric',
        ]);

        try {
            $this->getTable('scans_history')->insert([
                'user_id'       => session('lg_user_id'),
                'age_estimated' => $data['age'],
                'gender'        => $data['gender'] ?? 'Unknown',
                'verdict'       => $data['verdict'],
                'confidence'    => $data['confidence'] ?? 0.95,
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
}
