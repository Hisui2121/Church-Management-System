<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->date('birthdate')->nullable();
            $table->string('contact_number', 30)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('address', 285)->nullable();
            $table->string('profile_photo', 255)->nullable();
            $table->foreignId('member_status_id')
                  ->nullable()
                  ->constrained('member_statuses')
                  ->nullOnDelete();
            $table->dateTime('date_joined')->nullable();
            $table->foreignId('member_type_id')
                  ->nullable()
                  ->constrained('member_types')
                  ->nullOnDelete();
            $table->foreignId('baptism_id')
                  ->nullable()
                  ->constrained('baptisms')
                  ->nullOnDelete();
            $table->char('gender', 1)->nullable();
            $table->foreignId('family_group_id')
                  ->nullable()
                  ->constrained('family_groups')
                  ->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
