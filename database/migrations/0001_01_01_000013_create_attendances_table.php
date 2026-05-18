<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')
                  ->constrained('members')
                  ->cascadeOnDelete();
            $table->date('date');
            $table->foreignId('service_id')
                  ->constrained('services')
                  ->cascadeOnDelete();
            $table->boolean('is_present')->default(false);
            $table->foreignId('recorded_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamps();

            // A member can only have one attendance record per date
            $table->unique(['member_id', 'date'], 'member_date_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
