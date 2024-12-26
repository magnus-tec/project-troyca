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
        Schema::create('informacion_laboral', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_socio_id')->constrained('registro_socios')->onDelete('cascade');
            $table->enum('situacion', ['independiente', 'dependiente'])->nullable();
            $table->string('institucion_empresa')->nullable();
            $table->string('direccion_laboral')->nullable();
            $table->string('telefono_laboral')->nullable();
            $table->string('cargo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informacion_laboral');
    }
};
