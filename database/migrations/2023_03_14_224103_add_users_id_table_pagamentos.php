<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//php artisan make:migration add_users_id_table_pagamentos --table=pagamentos

return new class extends Migration
{
    public function up()
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->integer('users_id')
                        ->nullable()
                        ->after('status');
        });
    }

    public function down()
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropColumn('users_id');
        });
    }
};
