<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pieza', function (Blueprint $table) {
            $table->string('dni')->primary();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('situacion-dni')->default(null);
            $table->boolean('inscripcion_abierta');
            $table->boolean('inscripta_mipieza');
            $table->boolean('es_ganadora');
            $table->boolean('es_beneficiaria');
            $table->boolean('tiene_cvf');
            $table->string('cvf');
            $table->string('nro_tramite_dni');
            $table->string('estado_etapa');
            $table->boolean('de_baja');
            $table->string('situacion_pago');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pieza');
    }
};
