<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * FAMILY_GROUPS is created without the head_of_family FK here
     * because of a circular dependency with the MEMBER table.
     * The FK is added later in: add_foreign_keys_to_family_groups_table.php
     */
    public function up(): void
    {
        Schema::create('family_groups', function (Blueprint $table) {
            $table->id();
            $table->string('family_name', 160);
            $table->unsignedBigInteger('head_of_family')->nullable(); // FK added later
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_groups');
    }
};
