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
        Schema::table('prestamo_cuotas', function (Blueprint $table) {
            $table->decimal('mora', 10, 2)->after('subtotal')->default(0);
            $table->decimal('interes', 10, 2)->after('ted');
            $table->decimal('amortizacion', 10, 2)->after('interes');
        });

        DB::statement('UPDATE prestamo_cuotas SET interes = ted');
        Schema::table('prestamo_cuotas', function (Blueprint $table) {
            $table->dropColumn('ted');
            $table->dropColumn('fecha_pago');
        });
    }
};
