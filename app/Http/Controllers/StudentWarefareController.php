<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\StudentWarefare;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentWarefareController extends Controller
{
    // Display All Criteria
    public function position()
    {
        $criteria = Criterion::all();
        return view(
            'manage_candidate.view_rate_candidate',
            compact(
                [
                    'criteria',
                ],
            ),
        );
    }

    // Display All Candidate of Student Affair
    public function display()
    {
        $criterias = Criterion::all();
        $candidates = Candidate::all();
        $voterRate = Rating::all();
        return view(
            'manage_candidate.view_all_studentWarefare_candidate',
            compact(
                [
                    'candidates',
                    'criterias',
                    'voterRate',
                ],
            ),
        );
    }

    public function store(Request $request)
    {
        // 1. Get all criteria
        $criterias = Criterion::all();
        $criteriaIds = $criterias->pluck('id')->all();

        if (empty($criteriaIds)) {
            return back()->withErrors([
                'rate' => 'No rating criteria available.',
            ]);
        }

        // 2. Validate rating
        $rules = [
            'rate' => ['required', 'array'],
            'rate.*' => ['required', 'integer', 'between:1,5'],
            'candidate_name' => ['required', 'array'],
        ];

        foreach ($criteriaIds as $criteriaId) {
            $rules["rate.$criteriaId"] = [
                'required', 'integer', 'between:1,5'
            ];

            $rules["candidate_name.$criteriaId"] = [
                'required', 'string'
            ];
        }

        $request->validate($rules);

        // Ensure only existing criteria are submitted
        $submittedIds = array_keys($request->input('rate'));
        sort($submittedIds);
        sort($criteriaIds);

        if ($submittedIds != $criteriaIds) {
            return back()->withErrors([
                'rate' => 'Please rate all valid criteria.',
            ]);
        }

        // 3. Verify candidate
        $candidateNames = array_unique(
            array_values($request->input('candidate_name'))
        );

        if (count($candidateNames) !== 1) {
            return back()->withErrors([
                'rate' => 'Invalid candidate submission.',
            ]);
        }

        $candidateName = reset($candidateNames);

        $candidate = Candidate::where('full_name', $candidateName)
            ->where('position', 'Student Affair')
            ->first();

        if (!$candidate || $request->user()?->type !== 'voter') {
            abort(403, 'Unauthorized rating submission.');
        }

        $voterName = $request->user()->name;

        // 4. Save ratings and calculate averages
        DB::transaction(function () use (
            $request,
            $candidate,
            $candidateName,
            $voterName,
            $criterias
        ) {
            // Lock candidate to serialize concurrent submissions
            Candidate::whereKey($candidate->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Check duplicate rating
            $alreadyRated = Rating::where('candidate_name', $candidateName)
                ->where('voter_name', $voterName)
                ->whereIn('criteria_id', $criterias->pluck('id'))
                ->exists();

            if ($alreadyRated) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'rate' => 'You have already rated this candidate.',
                ]);
            }

            foreach ($criterias as $criteria) {
                $criteriaId = $criteria->id;

                // Save individual voter rating
                Rating::create([
                    'criteria_id' => $criteriaId,
                    'name' => $criteria->name,
                    'candidate_name' => $candidateName,
                    'voter_name' => $voterName,
                    'rate' => $request->input("rate.$criteriaId"),
                ]);

                // Recalculate average from actual voter ratings
                $average = Rating::where('criteria_id', $criteriaId)
                    ->where('candidate_name', $candidateName)
                    ->whereNotNull('voter_name')
                    ->where('voter_name', '!=', '')
                    ->avg('rate');

                // Store average for this candidate and criteria
                StudentWarefare::updateOrCreate(
                    [
                        'criteria_id' => $criteriaId,
                        'candidate_name' => $candidateName,
                    ],
                    [
                        'name' => $criteria->name,
                        'rate' => $average,
                    ]
                );
            }
        });

        return redirect('/voter/rateCandidate/student-warefare');
    }

}
