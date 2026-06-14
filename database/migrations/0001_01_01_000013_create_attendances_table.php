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
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->foreignId('service_session_id')
                    ->nullable()
                    ->constrained('service_sessions')
                    ->nullOnDelete();
                $table->date('date');
                $table->timestamp('checked_in_at')->nullable();
                $table->foreignId('service_id')
                    ->nullable()
                    ->constrained('services')
                    ->nullOnDelete();
                $table->boolean('is_present')->default(false);
                $table->foreignId('recorded_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();
                $table->timestamps();

                // Enforce one unique check-in per user per service session
                $table->unique(
                    ['member_id', 'service_session_id'],
                    'member_session_unique'
                );
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('attendances');
        }
    };
