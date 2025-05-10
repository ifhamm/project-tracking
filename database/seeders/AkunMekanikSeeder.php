<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AkunMekanikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('akun_mekaniks')->insert([
            [
                'id_mekanik' => Str::uuid(),
                'nama_mekanik' => 'Mekanik 1',
                'username' => 'mekanik1',
                'password' => Hash::make('Asep1234'),
                'email' => 'asep@example.com'
            ]
        ]);
    }
}
