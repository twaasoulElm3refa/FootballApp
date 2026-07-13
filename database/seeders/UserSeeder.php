<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'FootballAdmin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Ahmed Ali',
                'email' => 'ahmed.ali@gmail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'status' => 'banned',
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Mohamed Hassan',
                'email' => 'mohamed.hassan@yahoo.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'status' => 'suspended',
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Omar Khaled',
                'email' => 'omar.khaled@email.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'status' => 'deleted',
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Youssef Samir',
                'email' => 'youssef.samir@gamil.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Mahmoud Adel',
                'email' => 'mahmoud.adel@gmail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Mostafa Gamal',
                'email' => 'mostafa.gamal@email.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                 'status' => 'banned',
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Karim Tarek',
                'email' => 'karim.tarek@yahoo.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Hassan Ibrahim',
                'email' => 'hassan.ibrahim@gmail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
            [
                'username' => 'Ali Nasser',
                'email' => 'ali.nasser@yahoo.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'status' => 'suspended',
                'role' => 'user',
                'uuid' => Str::uuid(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
