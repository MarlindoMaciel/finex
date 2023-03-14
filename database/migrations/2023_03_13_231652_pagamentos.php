<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cartao',255);
            $table->string('numero_cartao',16);
            $table->integer('valor_pagamento')->default(0);
            $table->string('data_expiracao',7);
            $table->string('codigo_cvv',3);
            $table->string('status',30)->default('CRIADO');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamentos');
    }
};
