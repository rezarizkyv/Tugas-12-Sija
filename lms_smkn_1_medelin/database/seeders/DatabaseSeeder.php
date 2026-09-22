<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Membuat akun admin dan user biasa (siswa) default.
     */
    public function run(): void
    {
        // =============================================
        // AKUN ADMIN
        // Email   : admin@smkn1medelin.sch.id
        // Password: admin123
        // =============================================
        User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'email'    => 'admin@smkn1medelin.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'nis'      => null,
            'kelas'    => null,
        ]);

        // =============================================
        // AKUN SISWA / USER BIASA
        // Email   : siswa@smkn1medelin.sch.id
        // Password: siswa123
        // =============================================
        User::create([
            'name'     => 'Budi Santoso',
            'username' => 'budisantoso',
            'email'    => 'siswa@smkn1medelin.sch.id',
            'password' => Hash::make('siswa123'),
            'role'     => 'user',
            'nis'      => '1234567890',
            'kelas'    => 'XII RPL 1',
        ]);

        $this->call([
            CourseSeeder::class,
        ]);
    }
}
