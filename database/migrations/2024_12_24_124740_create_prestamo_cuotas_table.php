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
        Schema::create('prestamo_cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamos_id')->nullable()->constrained('prestamos')->onDelete('cascade');
            $table->date('fecha_pago');
            $table->date('fecha_vencimiento');
            $table->decimal('cuota', 10, 2);
            $table->decimal('saldo_capital', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('ted', 10, 2);
            $table->decimal('monto_pago', 10, 2);
            $table->date('fecha_pago_realizado')->nullable();
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamo_cuotas');
    }
};
