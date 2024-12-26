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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_solicitud');
            $table->foreignId('registro_socio_id')->nullable()->constrained('registro_socios')->onDelete('cascade');
            $table->string('producto');
            $table->string('garantia');
            $table->string('detalle_garantia');
            $table->date('fecha_desembolso');
            $table->string('dni');
            $table->string('asesor');
            $table->string('expediente');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
