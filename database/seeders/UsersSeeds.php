<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;

class UsersSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados =[ 
                    'name'          => 'Admin',
                    'email'         => 'admin@mpap.mp.br',
                    'password'      => '$1$MbSMV9Tu$GW1DGL5DDLEXHDdDuYRk10',
                ];
   
        DB::table('users')->delete();    
        DB::table('users')->insert($dados);    
    }
}
