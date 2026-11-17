<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            'Abraham Linkchon',
            'Al Fito Pratama',
            'Alifya Putri Tansya',
            'Al’Razan Muhammad Ihsan',
            'Bahy Alhady',
            'Dafta Jeth Athalayana',
            'Fadhillah Hafiz Al Rafi',
            'Fadlan Kelana',
            'Faiz Albar Rhamadhan',
            'Fajrina Shita Natasya',
            'Farel Rezky Aditya',
            'Farid Bahar Muharrom',
            'Fatar Gaza',
            'Giovanni Achmad Avicena',
            'Hafizh Al Ghazali',
            'Hainin Dwi Noviananda Fadly',
            'Hanif Muamar Irsyad',
            'Lingga Ramadhan',
            'Lydia Juniartha',
            'Maulana Arjuna Baadilah',
            'Muhamad Fakhri Fahlefi',
            'Muhammad Aditya Priatna',
            'Muhammad Iqbal Ramadhan',
            'Muhammad Ramadhan Setyo Nugroho',
            'Nayla Almaqhfira Ramadhani',
            'Putri Khania Zahra',
            'Quilla Mirza Jivandani',
            'Rainar Rizky Pangestu',
            'Razkimala Fabya Dalimunthe',
            'Reza Rizki Venino',
            'Sabian Noorkanz Abrisam',
            'Sangkara Guntur',
            'Syafira Putri Mentari',
            'Syafira Rahma Dhania',
            'Tiara Andini',
        ];

        // Hapus user demo siswa sebelumnya (jika ada) tapi pertahankan admin
        User::where('email', 'siswa@smkn1medelin.sch.id')->delete();

        $defaultPassword = Hash::make('12345');
        $nisStart = 20261001;

        foreach ($students as $index => $name) {
            // Bersihkan nama untuk username
            $cleanName = str_replace(["'", "’", "`"], '', $name);
            $slug = Str::slug($cleanName, '.');
            $username = str_replace('.', '', $slug); // misal abrahamlinkchon
            $email = $slug . '@smkn1medelin.sch.id';
            $nis = (string)($nisStart + $index);

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name'     => $name,
                    'username' => $username,
                    'password' => $defaultPassword,
                    'role'     => 'user',
                    'nis'      => $nis,
                    'kelas'    => 'XII RPL 1',
                ]
            );
        }
    }
}

