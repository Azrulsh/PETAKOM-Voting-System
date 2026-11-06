<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\Rating;
use Illuminate\Support\Collection;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index', $this->reportData());
    }

    public function display()
    {
        return view('report.generate', array_merge(
            $this->reportData(),
            [
                'voterRate' => Rating::all(),
            ]
        ));
    }

    private function reportData(): array
    {
        $criterias = Criterion::all();
        $candidates = Candidate::all();

        // Calculate average directly from ratings.
        $averages = Rating::query()
            ->selectRaw(
                'candidate_name, criteria_id, AVG(rate) AS rate'
            )
            ->whereNotNull('voter_name')
            ->where('voter_name', '!=', '')
            ->groupBy('candidate_name', 'criteria_id')
            ->get();

        // Preserve the data structure expected by old report Blades.
        $averages->each(function ($rating) use ($criterias) {
            $rating->name = $criterias
                ->firstWhere('id', $rating->criteria_id)?->name;
        });

        return [
            'criterias' => $criterias,
            'candidates' => $candidates,

            'totalStudentWarefare' => $this->byPosition(
                $averages,
                $candidates,
                'Student Affair'
            ),

            'totalWelfareExco' => $this->byPosition(
                $averages,
                $candidates,
                'Welfare Exco'
            ),

            'totalSportsExco' => $this->byPosition(
                $averages,
                $candidates,
                'Sports Exco'
            ),

            'totalSecretary' => $this->byPosition(
                $averages,
                $candidates,
                'Secretary'
            ),
        ];
    }

    private function byPosition(
        Collection $averages,
        Collection $candidates,
        string $position
    ): Collection {
        $candidateNames = $candidates
            ->where('position', $position)
            ->pluck('full_name');

        return $averages
            ->whereIn('candidate_name', $candidateNames)
            ->values();
    }
}
