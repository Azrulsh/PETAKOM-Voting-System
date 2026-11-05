<?php

namespace Database\Seeders;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $criteriaRatings = ManageCriteria::pluck('id')
            ->mapWithKeys(fn ($id) => [$id => 3])
            ->all();

        $candidates = [
            ['Ali Ahmad', 'CB30001', 'Student Affair'],
            ['Abu Bakar', 'CB30002', 'Student Affair'],

            ['Siti Aminah', 'CB30003', 'Welfare Exco'],
            ['Nur Aisyah', 'CB30004', 'Welfare Exco'],

            ['Muhammad Hakim', 'CB30005', 'Sports Exco'],
            ['Ahmad Danish', 'CB30006', 'Sports Exco'],

            ['Nur Izzati', 'CB30007', 'Secretary'],
            ['Siti Balqis', 'CB30008', 'Secretary'],
        ];

        foreach ($candidates as [$name, $matricId, $position]) {
            ManageCandidate::updateOrCreate(
                ['matric_id' => $matricId],
                [
                    'full_name' => $name,
                    'course' => 'Bachelor of Computer Science',
                    'year' => 2025,
                    'semester' => 2,
                    'position' => $position,
                    'manifesto' => 'Test candidate for PETAKOM Voting System.',
                    'video_link' => 'https://www.youtube.com/',
                    'image' => null,
                    'criteria_rate' => $criteriaRatings,
                ]
            );
        }
    }
}
