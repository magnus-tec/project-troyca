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
        Schema::table('datos_personales', function (Blueprint $table) {
            $table->enum('tipo_documento', ['DNI', 'Pasaporte'])->default('DNI');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_personales', function (Blueprint $table) {
            $table->dropColumn('tipo_documento');
        });
    }
};
