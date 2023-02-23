<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name'        => 'Test',
                'last_name'         => 'One',
                'email'             => 'test_1@test.com',
                'email_verified_at'    => now(),
                'password'          => Hash::make('123456789'),
                'phone'             => '01010568214',
                'lat'               => fake()->latitude(),
                'lng'               => fake()->longitude(),
                'profile_image'     => 'image/client-profile.png',
                'drive_licence'     => 'image/client-profile.png'
            ],
            [
                'first_name'        => 'Test',
                'last_name'         => 'Two',
                'email'             => 'test_2@test.com',
                'email_verified_at'     => now(),
                'password'      => Hash::make('123456789'),
                'phone'      => '01010568214',
                'lat'       => fake()->latitude(),
                'lng'       => fake()->longitude(),
                'profile_image'     => 'image/client-profile.png',
                'drive_licence'     => 'image/client-profile.png'
            ],

            [
                'first_name'        => 'Test',
                'last_name'         => 'Three',
                'email'             => 'test_3@test.com',
                'email_verified_at'     => now(),
                'password'          => Hash::make('123456789'),
                'phone'             => '01010568214',
                'lat'               => fake()->latitude(),
                'lng'               => fake()->longitude(),
                'profile_image'     => 'image/client-profile.png',
                'drive_licence'     => 'image/client-profile.png'
            ],

            [
                'first_name'        => 'Test',
                'last_name'         => 'Four',
                'email'             => 'test_4@test.com',
                'email_verified_at'     => now(),
                'password'          => Hash::make('123456789'),
                'phone'             => '01010568214',
                'lat'               => fake()->latitude(),
                'lng'               => fake()->longitude(),
                'profile_image'     => 'image/client-profile.png',
                'drive_licence'     => 'image/client-profile.png'
            ],

            [
                'first_name'        => 'Test',
                'last_name'         => 'Five',
                'email'             => 'test_5@test.com',
                'email_verified_at'     => now(),
                'password'          => Hash::make('123456789'),
                'phone'             => '01010568214',
                'lat'               => fake()->latitude(),
                'lng'               => fake()->longitude(),
                'profile_image'     => 'image/client-profile.png',
                'drive_licence'     => 'image/client-profile.png'
            ],

        ];

        foreach($users as $key => $user){
            User::create($user)->assignRole('user');
        }

        
        $admin = [
            'first_name'        => 'Super',
            'last_name'         => 'Admin',
            'email'             => 'admin@admin.com',
            'email_verified_at'    => now(),
            'password'          => Hash::make('123456789'),
            'phone'             => '01010568214',
            'lat'               => fake()->latitude(),
            'lng'               => fake()->longitude(),
            'profile_image'     => 'image/client-profile.png',
            'drive_licence'     => 'image/client-profile.png'
        ];
        User::create($admin)->assignRole('admin');
    }
}
