<?php
// database/migrations/2025_01_01_000004_create_pricing_breakdowns_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pricing_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->decimal('base_amount_in_inr', 14, 2);
            $table->string('currency', 10);
            $table->decimal('fx_rate_at_booking', 18, 8);
            $table->decimal('total_in_currency', 14, 2);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pricing_breakdowns'); }
};
