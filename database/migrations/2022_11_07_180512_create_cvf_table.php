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
        Schema::create('cvf', function (Blueprint $table) {
            $table->string('dni')->primary();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('f01');
            $table->string('f02');
            $table->string('f03');
            $table->string('f04');
            $table->string('f05');
            $table->boolean('encuesta_realizada');
            $table->boolean('tiene_cvf');
            $table->string('cvf');
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
        Schema::dropIfExists('cvf');
    }
};
