<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Now that MEMBER exists, add the deferred foreign keys
     * to BAPTISMS and FAMILY_GROUPS.
     */
    public function up(): void
    {
        Schema::table('baptisms', function (Blueprint $table) {
            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')
                  ->nullOnDelete();
        });

        Schema::table('family_groups', function (Blueprint $table) {
            $table->foreign('head_of_family')
                  ->references('id')
                  ->on('members')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('baptisms', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
        });

        Schema::table('family_groups', function (Blueprint $table) {
            $table->dropForeign(['head_of_family']);
        });
    }
};
