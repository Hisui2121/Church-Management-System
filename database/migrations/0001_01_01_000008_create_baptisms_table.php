<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * BAPTISM is created without the member_id FK here because of
     * a circular dependency with the MEMBER table.
     * The FK is added later in: add_foreign_keys_to_baptisms_table.php
     */
    public function up(): void
    {
        Schema::create('baptisms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable(); // FK added later
            $table->string('status', 90);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baptisms');
    }
};
