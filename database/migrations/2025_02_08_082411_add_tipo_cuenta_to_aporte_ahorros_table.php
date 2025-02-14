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
        Schema::table('aporte_ahorros', function (Blueprint $table) {
            $table->string('tipo_cuenta')->default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aporte_ahorros', function (Blueprint $table) {
            $table->dropColumn('tipo_cuenta');
        });
    }
};
