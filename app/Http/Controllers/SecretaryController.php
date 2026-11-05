<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use App\Models\Secretary;
use App\Models\VoterRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecretaryController extends Controller
{
    // Display All Candidate of Secretary
    public function display()
    {
        $criterias = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        $voterRate = VoterRate::all();
        return view(
            'manage_candidate.view_all_secretary_candidate',
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
        $criterias = ManageCriteria::all();
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

        $candidate = ManageCandidate::where('full_name', $candidateName)
            ->where('position', 'Secretary')
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
            ManageCandidate::whereKey($candidate->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Check duplicate rating
            $alreadyRated = VoterRate::where('candidate_name', $candidateName)
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
                VoterRate::create([
                    'criteria_id' => $criteriaId,
                    'name' => $criteria->name,
                    'candidate_name' => $candidateName,
                    'voter_name' => $voterName,
                    'rate' => $request->input("rate.$criteriaId"),
                ]);

                // Recalculate average from actual voter ratings
                $average = VoterRate::where('criteria_id', $criteriaId)
                    ->where('candidate_name', $candidateName)
                    ->whereNotNull('voter_name')
                    ->where('voter_name', '!=', '')
                    ->avg('rate');

                // Store average for this candidate and criteria
                Secretary::updateOrCreate(
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

        return redirect('/voter/rateCandidate/secretary');
    }

}
