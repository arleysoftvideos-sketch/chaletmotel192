<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('lg_users')) {
            Schema::table('lg_users', function (Blueprint $table) {
                if (!Schema::hasColumn('lg_users', 'months_purchased')) {
                    $table->integer('months_purchased')->default(1)->after('subscription_expires_at');
                }
                if (!Schema::hasColumn('lg_users', 'max_devices')) {
                    $table->integer('max_devices')->default(1)->after('can_view_logs');
                }
                if (!Schema::hasColumn('lg_users', 'language')) {
                    $table->string('language', 10)->default('es')->after('custom_min_age');
                }
                if (!Schema::hasColumn('lg_users', 'updated_at')) {
                    $table->dateTime('updated_at')->nullable()->after('created_at');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('lg_users')) {
            Schema::table('lg_users', function (Blueprint $table) {
                if (Schema::hasColumn('lg_users', 'months_purchased')) $table->dropColumn('months_purchased');
                if (Schema::hasColumn('lg_users', 'max_devices')) $table->dropColumn('max_devices');
                if (Schema::hasColumn('lg_users', 'language')) $table->dropColumn('language');
                if (Schema::hasColumn('lg_users', 'updated_at')) $table->dropColumn('updated_at');
            });
        }
    }
};
