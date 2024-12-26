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
        Schema::create('aporte_ahorros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_socio_id')->nullable()->constrained('registro_socios')->onDelete('cascade');
            $table->decimal('total_aportes');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aporte_ahorros');
    }
};
