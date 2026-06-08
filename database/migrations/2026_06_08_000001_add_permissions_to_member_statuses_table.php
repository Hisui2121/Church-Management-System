<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add a JSON `permissions` column to member_statuses.
     * Admin can set which actions each status is allowed to perform.
     *
     * Example value:
     *   ["view_members","view_dashboard"]
     */
    public function up(): void
    {
        Schema::table('member_statuses', function (Blueprint $table) {
            $table->json('permissions')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('member_statuses', function (Blueprint $table) {
            $table->dropColumn('permissions');
        });
    }
};
