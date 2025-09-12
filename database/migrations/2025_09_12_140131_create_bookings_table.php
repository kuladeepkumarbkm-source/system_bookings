<?php
// database/migrations/2025_01_01_000003_create_bookings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->enum('type', ['flight','hotel']);
            $table->string('item_id');
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->string('currency', 10)->default('INR');
            $table->decimal('total_amount', 14, 2);
            $table->string('status')->default('confirmed');
            $table->decimal('fx_rate_at_booking', 18, 8)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bookings'); }
};
