<?php

namespace Database\Seeders;

use App\Models\ManageCriteria;
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
            ManageCriteria::firstOrCreate(
                ['name' => $name],
                [
                    'rate' => 0,
                ]
            );
        }
    }
}
