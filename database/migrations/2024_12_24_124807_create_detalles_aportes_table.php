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
        Schema::create('detalles_aportes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aporte_id')->nullable()->constrained('aporte_ahorros')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_aportes');
    }
};
