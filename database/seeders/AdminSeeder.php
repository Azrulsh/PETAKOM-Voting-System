<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@petakom.test'],
            [
                'name' => 'PETAKOM Admin',
                'user_id' => 'ADMIN001',
                'type' => 'admin',
                'phoneNo' => '0123456789',
                'password' => Hash::make('password1@3'),
                'email_verified_at' => now(),
            ]
        );
    }
}
