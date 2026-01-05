<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin BMKG',
            'email' => 'admin@bmkg.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Pimpinan User
        User::create([
            'name' => 'Kepala BMKG',
            'email' => 'pimpinan@bmkg.go.id',
            'password' => Hash::make('pimpinan123'),
            'role' => 'pimpinan',
        ]);

        echo "✅ User seeder berhasil!\n";
        echo "Admin: admin@bmkg.go.id | Password: admin123\n";
        echo "Pimpinan: pimpinan@bmkg.go.id | Password: pimpinan123\n";
    }
}