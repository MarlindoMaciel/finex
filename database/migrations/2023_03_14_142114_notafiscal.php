<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notafiscal', function (Blueprint $table) {
            $table->id();
            $table->string('nome',255);
            $table->string('email',255);
            $table->integer('cpf');
            $table->string('telefone',30);
            $table->string('rua',255);
            $table->string('numero',9);
            $table->string('bairro',255);
            $table->string('cidade',255);
            $table->string('estado',255);
            $table->integer('pagamentos_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notafiscal');
    }
};
