<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {

            $table->id();

            // BASIC INFO
            $table->string('first_name');
            $table->string('last_name');

            $table->date('birthdate')->nullable();

            $table->enum('gender', ['Male', 'Female']);
            
            // CONTACT
            $table->string('contact_number')->nullable();

            $table->string('email')->nullable();

            $table->text('address')->nullable();

            // PROFILE
            $table->string('profile_photo')->nullable();

            // STATUS
            $table->string('member_status')->default('Active');

            $table->string('member_type')->default('Regular');

            // CHURCH
            $table->date('date_joined')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};