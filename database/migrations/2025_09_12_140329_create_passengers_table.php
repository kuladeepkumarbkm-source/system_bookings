<?php
// database/migrations/2025_01_01_000005_create_passengers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('passengers'); }
};
