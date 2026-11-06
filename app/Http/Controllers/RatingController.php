<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RatingController extends Controller
{
    private const POSITIONS = [
        'student-affair' => 'Student Affair',
        'welfare-exco' => 'Welfare Exco',
        'sports-exco' => 'Sports Exco',
        'secretary' => 'Secretary',
    ];

    public function positions()
    {
        return view('rating.positions', [
            'criteria' => Criterion::all(),
        ]);
    }

    public function index(string $position)
    {
        $positionName = $this->getPosition($position);

        $criterias = Criterion::all();

        $candidates = Candidate::where('position', $positionName)->get();

        $voterRate = Rating::where('voter_name', auth()->user()->name)->get();

        return view('rating.index', compact( 'criterias', 'candidates', 'voterRate', 'position'));
    }

    public function store(Request $request, string $position)
    {
        $positionName = $this->getPosition($position);

        abort_unless(
            $request->user()?->type === 'voter',
            403
        );

        $criteriaIds = Criterion::pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        if (empty($criteriaIds)) {
            throw ValidationException::withMessages([
                'rate' => 'No rating criteria are available.',
            ]);
        }

        $rules = [
            'rate' => ['required', 'array'],
            'candidate_name' => ['required', 'array'],
        ];

        foreach ($criteriaIds as $id) {
            $rules["rate.$id"] = [
                'required', 'integer', 'between:1,5',
            ];

            $rules["candidate_name.$id"] = [
                'required', 'string',
            ];
        }

        $data = $request->validate($rules);

        $submittedIds = array_map(
            'intval',
            array_keys($data['rate'])
        );

        sort($submittedIds);
        $expectedIds = $criteriaIds;
        sort($expectedIds);

        if ($submittedIds !== $expectedIds) {
            throw ValidationException::withMessages([
                'rate' => 'Invalid rating criteria submitted.',
            ]);
        }

        $candidateNames = array_unique(
            array_values($data['candidate_name'])
        );

        if (count($candidateNames) !== 1) {
            throw ValidationException::withMessages([
                'candidate_name' => 'Invalid candidate selection.',
            ]);
        }

        $candidateName = reset($candidateNames);

        $candidate = Candidate::where('full_name', $candidateName)
            ->where('position', $positionName)
            ->first();

        abort_unless($candidate, 403);

        $voterName = $request->user()->name;

        DB::transaction(function () use (
            $candidate,
            $candidateName,
            $voterName,
            $criteriaIds,
            $data
        ) {
            Candidate::whereKey($candidate->id)
                ->lockForUpdate()
                ->firstOrFail();

            $alreadyRated = Rating::where(
                'candidate_name',
                $candidateName
            )->where('voter_name', $voterName)
                ->exists();

            if ($alreadyRated) {
                throw ValidationException::withMessages([
                    'rate' => 'You have already rated this candidate.',
                ]);
            }

            foreach ($criteriaIds as $id) {
                $criterion = Criterion::findOrFail($id);

                Rating::create([
                    'criteria_id' => $id,
                    'name' => $criterion->name,
                    'candidate_name' => $candidateName,
                    'voter_name' => $voterName,
                    'rate' => $data['rate'][$id],
                ]);
            }
        });

        return redirect()
            ->route('voter.ratings.index', ['position' => $position])
            ->with('success', 'Rating submitted successfully.');
            
    }

    private function getPosition(string $position): string
    {
        abort_unless(
            array_key_exists($position, self::POSITIONS),
            404
        );

        return self::POSITIONS[$position];
    }
}
