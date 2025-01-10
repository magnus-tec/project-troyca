<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('aporte_ahorros', function (Blueprint $table) {
            $table->timestamp('fecha_registro')->default(DB::raw('CURRENT_TIMESTAMP'))->after('estado');
            $table->string('codigo', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aporte_ahorros', function (Blueprint $table) {
            $table->dropColumn(['fecha_registro', 'codigo']);
        });
    }
};
