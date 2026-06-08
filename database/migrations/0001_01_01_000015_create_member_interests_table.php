<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_interests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                  ->constrained('members')
                  ->cascadeOnDelete();
            $table->foreignId('ministry_id')
                  ->constrained('ministries')
                  ->cascadeOnDelete();
            $table->date('expressed_at')->nullable();
            $table->timestamps();

            // A member can only express interest in a ministry once
            $table->unique(['member_id', 'ministry_id'], 'member_interest_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_interests');
    }
};
