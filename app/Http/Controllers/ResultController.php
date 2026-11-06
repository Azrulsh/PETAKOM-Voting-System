<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\Rating;

class ResultController extends Controller
{
    
    public function index()
    {
        $criteriaIds = Criterion::pluck('id');

        $calculateWinner = function (string $position) use ($criteriaIds) {
            if ($criteriaIds->isEmpty()) {
                return [null, null];
            }

            $candidates = Candidate::where('position', $position)->get();

            $scores = [];

            foreach ($candidates as $candidate) {
                $criteriaAverages = [];

                foreach ($criteriaIds as $criteriaId) {
                    $average = Rating::where(
                        'candidate_name',
                        $candidate->full_name
                    )
                        ->where('criteria_id', $criteriaId)
                        ->whereNotNull('voter_name')
                        ->where('voter_name', '!=', '')
                        ->avg('rate');

                    if ($average === null) {
                        continue 2;
                    }

                    $criteriaAverages[] = (float) $average;
                }

                $scores[] = [
                    'name' => $candidate->full_name,
                    'matric_id' => $candidate->matric_id,
                    'score' => array_sum($criteriaAverages)
                        / count($criteriaAverages),
                ];
            }

            if (empty($scores)) {
                return [null, null];
            }

            $maxScore = max(array_column($scores, 'score'));

            // Preserve tied candidates instead of selecting arbitrarily
            $winners = array_filter(
                $scores,
                fn ($item) => abs($item['score'] - $maxScore) < 0.000001
            );

            return [
                implode(', ', array_column($winners, 'name')),
                implode(', ', array_column($winners, 'matric_id')),
            ];
        };

        [$candidateNameSW, $candidateIdSW] =
            $calculateWinner('Student Affair');

        [$candidateNameWE, $candidateIdWE] =
            $calculateWinner('Welfare Exco');

        [$candidateNameSE, $candidateIdSE] =
            $calculateWinner('Sports Exco');

        [$candidateNameS, $candidateIdS] =
            $calculateWinner('Secretary');

        return view('report.result', compact(
            'candidateNameSW',
            'candidateIdSW',
            'candidateNameWE',
            'candidateIdWE',
            'candidateNameSE',
            'candidateIdSE',
            'candidateNameS',
            'candidateIdS'
        ));
    }

}
