<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add member_status_id to users so each user inherits the permissions
     * defined on their member status by the admin.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('member_status_id')
                  ->nullable()
                  ->constrained('member_statuses')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['member_status_id']);
            $table->dropColumn('member_status_id');
        });
    }
};
