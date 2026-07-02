<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('personas', function (Blueprint $table) {
        // Agregamos la columna nivel_riesgo (Bajo, Medio, Alto)
        // Por defecto todos empiezan en 'Bajo'
        $table->string('nivel_riesgo')->default('Bajo')->after('id_rol');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personas', function (Blueprint $table) {
            //
        });
    }
};
