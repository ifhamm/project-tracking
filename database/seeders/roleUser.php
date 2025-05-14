<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class roleUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('credentials')->insert([
            [
                'id_credentials' => Str::uuid(),
                'name' => 'Ilham Fauza',
                'password' => Hash::make('Ilham1234'),
                'email' => 'ilham@gmail.com',
                'nik' => '1122334455667788',
                'role' => 'pm'
            ],
            [
                'id_credentials' => Str::uuid(),
                'name' => 'Azhar albhaqi',
                'password' => Hash::make('azhar1234'),
                'email' => 'azhar@gmail.com',
                'nik' => '1020304050607080',
                'role' => 'superadmin'
            ],
            [
                'id_credentials' => Str::uuid(),
                'name' => 'Prakasha',
                'password' => Hash::make('Prakasha1234'),
                'email' => 'Prakasha@gmail.com',
                'nik' => '1010101010101010',
                'role' => 'mekanik'
            ]
        ]);
    }
}
