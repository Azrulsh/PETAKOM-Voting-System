<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VoterSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "voter{$i}@petakom.test"],
                [
                    'name' => "Voter {$i}",
                    'user_id' => sprintf('CB%05d', $i),
                    'type' => 'voter',
                    'phoneNo' => sprintf('012345%04d', $i),
                    'password' => Hash::make('password1@3'),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
