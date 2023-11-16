<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use App\Models\SportsExco;
use App\Models\VoterRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SportsExcoController extends Controller
{
    // Display All Candidate of Sports Exco
    public function display()
    {
        $criterias = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        $voterRate = VoterRate::all();
        return view(
            'manage_candidate.view_all_sportsExco_candidate',
            compact(
                [
                    'candidates',
                    'criterias',
                    'voterRate',
                ],
            ),
        );
    }

    // Store Candidate Rate of Welfare Exco DB
    public function store(Request $request)
    {
        $numberVoter = DB::table('users')->where('type', 'voter')->count();
        $numberVoterDouble = floatval($numberVoter);

        foreach ($request->input('rate') as $criteriaId => $rateValueInput) {
            $voterName = VoterRate::where('id', $criteriaId)->value('voter_name');
            $candidateName = VoterRate::where('id', $criteriaId)->value('candidate_name');

            $candidateSportsExco = SportsExco::where('id', $criteriaId)->value('candidate_name');

            // Fetch all candidate names for the given criteria from the database
            $allCandidateNames = VoterRate::where('criteria_id', $criteriaId)->pluck('candidate_name')->toArray();

            // Check if the candidate name from user input exists in the database
            if (in_array($request->input('candidate_name.' . $criteriaId), $allCandidateNames)) {
                $rateValueDB = SportsExco::where('id', $criteriaId)->value('rate');
            } else {
                $rateValueDB = 0.0;
            }

            // Ensure $rateValue is a numeric value before division
            $rateValueDouble = floatval($rateValueInput);

            $totalAverageRate = ($rateValueDouble + $rateValueDB) / $numberVoterDouble;

            // Check if $averageRate is greater than or equal to 0 before updating the database
            if ($rateValueDouble >= 0) {
                if ($voterName == null) {
                    // Update the database for the initial total average Student Affair
                    SportsExco::where('id', $criteriaId)->update([
                        'criteria_id' => $criteriaId,
                        'candidate_name' => $request->input('candidate_name.' . $criteriaId),
                        'rate' => $totalAverageRate,
                    ]);

                    // Update the database for the initial specific criteria
                    VoterRate::where('id', $criteriaId)->update([
                        'criteria_id' => $criteriaId,
                        'name' => $request->input('criteria_name.' . $criteriaId),
                        'candidate_name' => $request->input('candidate_name.' . $criteriaId),
                        'voter_name' => $request['voter_name'],
                        'rate' => $rateValueDouble,
                    ]);
                } else {
                    VoterRate::create([
                        'criteria_id' => $criteriaId,
                        'name' => $request->input('criteria_name.' . $criteriaId),
                        'candidate_name' => $request->input('candidate_name.' . $criteriaId),
                        'voter_name' => $request['voter_name'],
                        'rate' => $rateValueDouble,
                    ]);

                    if ($candidateSportsExco == null) {
                        // Update the database for the initial total average Student Affair
                        SportsExco::where('id', $criteriaId)->update([
                            'criteria_id' => $criteriaId,
                            'candidate_name' => $request->input('candidate_name.' . $criteriaId),
                            'rate' => $totalAverageRate,
                        ]);

                        VoterRate::create([
                            'criteria_id' => $criteriaId,
                            'name' => $request->input('criteria_name.' . $criteriaId),
                            'candidate_name' => $request->input('candidate_name.' . $criteriaId),
                            'voter_name' => $request['voter_name'],
                            'rate' => $rateValueDouble,
                        ]);
                    } else {
                        if ($request->input('candidate_name.' . $criteriaId) == $candidateName) {
                            // Update the database for the Student Affair total Average
                            SportsExco::where('id', $criteriaId)->update([
                                'criteria_id' => $criteriaId,
                                'rate' => $totalAverageRate,
                            ]);
                        } else {
                            // Check if a record already exists for the new candidate_name
                            $existingRecord = SportsExco::where('candidate_name', $request->input('candidate_name.' . $criteriaId))
                                ->where('criteria_id', $criteriaId)
                                ->first();

                            if ($existingRecord) {
                                // Update the existing record
                                $existingRecord->update([
                                    'rate' => $totalAverageRate,
                                ]);
                            } else {
                                // Create a new record in the database for the Student Affair total Average
                                SportsExco::create([
                                    'criteria_id' => $criteriaId,
                                    'candidate_name' => $request->input('candidate_name.' . $criteriaId),
                                    'name' => $request->input('criteria_name.' . $criteriaId),
                                    'rate' => $totalAverageRate,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect('/voter/rateCandidate/sports-exco');
    }
}
