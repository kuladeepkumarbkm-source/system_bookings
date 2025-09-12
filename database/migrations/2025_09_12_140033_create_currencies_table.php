<?php
// database/migrations/2025_01_01_000002_create_currencies_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();
            $table->decimal('value', 18, 8)->default(1);
            $table->timestamp('updated_at')->nullable();
        });
    }
    public function down(): void { Schema::dropIfExists('currencies'); }
};
