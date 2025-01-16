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
        Schema::table('prestamos', function (Blueprint $table) {
            $table->string('garantia')->nullable()->change();
            $table->string('detalle_garantia')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            'prestamos',
            function (Blueprint $table) {

                $table->string('garantia')->nullable(false)->change();
                $table->string('detalle_garantia')->nullable(false)->change();
            }
        );
    }
};
