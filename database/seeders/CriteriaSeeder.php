<?php

namespace Database\Seeders;

use App\Models\Criterion;
use Illuminate\Database\Seeder;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $criterias = [
            'Academic',
            'Leadership',
            'Communication',
            'Experience',
        ];

        foreach ($criterias as $name) {
            Criterion::firstOrCreate(
                ['name' => $name],
                [
                    'rate' => 0,
                ]
            );
        }
    }
}
