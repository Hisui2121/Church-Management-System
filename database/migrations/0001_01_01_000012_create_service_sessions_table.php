<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_sessions', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(false);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->foreignId('started_by_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->date('session_date');
            $table->foreignId('pastor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('service_title')->nullable();
            $table->text('verse')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_sessions');
    }
};
