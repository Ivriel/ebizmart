<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_user' => 'Administrator',
            'username' => 'admin_toko',
            'password' => Hash::make('password123'), // Pastikan di-hash
            'role' => 'admin',
            'alamat' => 'Jl. Raya No. 123, Malang',
        ]);
    }
}
