<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'ws@catalogo.admin';

        // se já existir, atualiza; senão cria
        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'name'      => 'Administrador',
                'password'  => Hash::make('ws@2026*'), // troca depois!
                'is_admin'  => true,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]
        );
    }
}
