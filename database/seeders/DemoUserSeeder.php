<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Client User',
                'email' => 'client@crms.test',
                'password' => 'password',
                'role' => 'client',
            ],
            [
                'name' => 'Developer User',
                'email' => 'developer@crms.test',
                'password' => 'password',
                'role' => 'developer',
            ],
            [
                'name' => 'Manager User',
                'email' => 'manager@crms.test',
                'password' => 'password',
                'role' => 'manager',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($userData['password']),
                    'role' => $userData['role'],
                    'email_verified_at' => now(),
                ]
            );

            $user->syncRoles([$userData['role']]);
        }
    }
}
