<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('lg_users')) {
            Schema::create('lg_users', function (Blueprint $table) {
                $table->id();
                $table->string('business_name', 200);
                $table->string('contact_name', 150)->nullable();
                $table->string('email', 200)->unique();
                $table->string('password_hash', 255);
                $table->string('role', 20)->default('client');
                $table->string('status', 20)->default('active');
                $table->dateTime('subscription_expires_at')->default('2099-12-31 23:59:59');
                $table->integer('months_purchased')->default(1);
                $table->boolean('can_export_reports')->default(false);
                $table->boolean('can_change_min_age')->default(false);
                $table->boolean('can_view_logs')->default(true);
                $table->integer('max_devices')->default(1);
                $table->integer('custom_min_age')->default(18);
                $table->dateTime('last_login')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('lg_scans_history')) {
            Schema::create('lg_scans_history', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->decimal('age_estimated', 5, 2)->nullable();
                $table->string('gender', 20)->nullable();
                $table->string('verdict', 20);
                $table->decimal('confidence', 5, 4)->default(0.95);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('lg_audit_logs')) {
            Schema::create('lg_audit_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('action', 100);
                $table->text('details')->nullable();
                $table->string('ip_address', 50)->nullable();
                $table->timestamps();
            });
        }

        // Seed or update Super Admin
        $superEmail = 'jovan.suarez.za@gmail.com';
        $superPass = Hash::make('Sebastian1511+');

        $exists = DB::table('lg_users')->where('email', $superEmail)->first();
        if (!$exists) {
            DB::table('lg_users')->insert([
                'business_name' => 'LiquorGuard Headquarters',
                'contact_name' => 'Jovan Suarez',
                'email' => $superEmail,
                'password_hash' => $superPass,
                'role' => 'superadmin',
                'status' => 'active',
                'subscription_expires_at' => '2099-12-31 23:59:59',
                'months_purchased' => 999,
                'can_export_reports' => true,
                'can_change_min_age' => true,
                'can_view_logs' => true,
                'max_devices' => 100,
                'custom_min_age' => 18,
            ]);
        } else {
            DB::table('lg_users')->where('email', $superEmail)->update([
                'password_hash' => $superPass,
                'role' => 'superadmin',
                'status' => 'active',
                'subscription_expires_at' => '2099-12-31 23:59:59',
                'can_export_reports' => true,
                'can_change_min_age' => true,
                'can_view_logs' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lg_audit_logs');
        Schema::dropIfExists('lg_scans_history');
        Schema::dropIfExists('lg_users');
    }
};
