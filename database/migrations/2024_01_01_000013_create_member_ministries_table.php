<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_ministries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                  ->constrained('members')
                  ->cascadeOnDelete();
            $table->foreignId('ministry_id')
                  ->constrained('ministries')
                  ->cascadeOnDelete();
            $table->date('joined_at')->nullable();
            $table->string('role', 100)->nullable();
            $table->timestamps();

            // A member can only be assigned to a ministry once
            $table->unique(['member_id', 'ministry_id'], 'member_ministry_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_ministries');
    }
};
