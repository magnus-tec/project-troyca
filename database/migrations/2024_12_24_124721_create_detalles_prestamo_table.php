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
        Schema::create('detalles_prestamo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamos_id')->nullable()->constrained('prestamos')->onDelete('cascade');
            $table->decimal('monto', 10, 2);
            $table->string('modalidad');
            $table->decimal('tem', 10, 2);
            $table->integer('cantidad_cuotas');
            $table->decimal('cuota', 10, 2);
            $table->date('f_primera_cuota');
            $table->decimal('ted', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_prestamo');
    }
};
