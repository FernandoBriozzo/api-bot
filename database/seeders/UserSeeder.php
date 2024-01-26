<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        
        DB::table('users')->insert([
            [
                'name' => 'UsuarioBot01',
                'password' => Hash::make('p3258T974E')
            ],
            [
                'name' => 'UsuarioSalta01',
                'password' => Hash::make('RwiVve76LJ')
            ],
            [
                'name' => 'UsuarioRenaper',
                'password' => Hash::make('r5Ci6F4h2Q')
            ]
        ]);
    }
}
