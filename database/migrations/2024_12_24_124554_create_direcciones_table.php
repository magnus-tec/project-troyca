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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_socio_id')->constrained()->onDelete('cascade');
            $table->string('departamento')->nullable();
            $table->string('provincia')->nullable();
            $table->string('distrito')->nullable();
            $table->enum('tipo_vivienda', ['propia', 'alquilada', 'familiar', 'otro'])->nullable();
            $table->string('direccion')->nullable();
            $table->string('referencia')->nullable()->nullable();
            $table->string('telefono')->nullable()->nullable();
            $table->string('correo')->nullable()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
