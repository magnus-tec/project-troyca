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
        Schema::table('prestamo_cuotas', function (Blueprint $table) {
            $table->decimal('mora', 10, 2);
            $table->renameColumn('ted', 'interes');
            $table->decimal('amortizacion', 10, 2);
            $table->dropColumn('fecha_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestamo_cuotas', function (Blueprint $table) {
            $table->dropColumn('mora');
            $table->dropColumn('amortizacion');
            $table->renameColumn('interes', 'ted');
            $table->date('fecha_pago')->after('prestamos_id');
        });
    }
};
