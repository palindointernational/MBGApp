<?php

namespace Database\Seeders;

use App\Models\Kitchen;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mbg.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');
        User::create([
            'name' => 'SPPG Rancagoong 3',
            'email' => 'sppgrancagoong@mbg.com',
            'password' => bcrypt('password'),
        ])->assignRole('kitchen');

        Kitchen::create([
            'user_id' => 2,
            'name' => 'SPPG Rancagoong 3',
            'slug' => 'sppg-rancagoong-3',
            'address' => 'Jl. Rancagoong No.3, RT.01/RW.01, Cibogo, Kec. Cibogo, Kabupaten Subang, Jawa Barat 41281',
            'phone' => '081234567890',
        ]);
    }
}
