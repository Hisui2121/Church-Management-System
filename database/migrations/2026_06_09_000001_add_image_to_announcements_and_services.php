<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add image to announcements
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('body');
        });

        // Add image to services (events)
        Schema::table('services', function (Blueprint $table) {
            $table->string('image_path')->nullable()->after('description');
            $table->dateTime('event_date')->nullable()->after('image_path');
            $table->string('event_time')->nullable()->after('event_date');
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('image_path');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['image_path', 'event_date', 'event_time']);
        });
    }
};
