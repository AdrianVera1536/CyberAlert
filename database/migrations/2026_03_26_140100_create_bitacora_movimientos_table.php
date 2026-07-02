<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacora_movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tabla');
            $table->string('accion'); // INSERT, UPDATE, DELETE
            $table->string('usuario'); // Guardará quién hizo el cambio
            $table->json('detalles'); // Aquí guardaremos todo el registro
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacora_movimientos');
    }
};