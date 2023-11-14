<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use App\Models\VoterRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RateCandidateController extends Controller
{
    // Display All Criteria
    public function position()
    {
        $criteria = ManageCriteria::all();
        return view(
            'manage_candidate.view_rate_candidate',
            compact(
                [
                    'criteria',
                ],
            ),
        );
    }

    // Display All Candidate of Student Warefare
    public function display()
    {
        $criterias = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        $voterRate = VoterRate::all();
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

    // Store Candidate Rate of Student Warefare DB
    public function store(Request $request)
    {
        $numberVoter = DB::table('users')->where('type', 'voter')->count();
        $numberVoterDouble = floatval($numberVoter);

        foreach ($request->input('rate') as $criteriaId => $rateValueInput) {

            $voterName = VoterRate::where('id', $criteriaId)->value('voter_name');


            $rateValueDB = ManageCriteria::where('id', $criteriaId)->value('rate');


            // Ensure $rateValue is a numeric value before division
            $rateValueDouble = floatval($rateValueInput);

            // Calculate the new average rate
            $averageRate = ($rateValueDouble + $rateValueDB) / $numberVoterDouble; // Assuming you are adding a new vote

            // Check if $averageRate is greater than or equal to 0 before updating the database
            if ($averageRate >= 0) {

                if ($voterName == null) {
                    if ($voterName == null) {
                        // Update the database for the specific criteria
                        ManageCriteria::where('id', $criteriaId)->update([
                            'rate' => $averageRate,
                        ]);

                        // Update the database for the specific criteria
                        VoterRate::where('id', $criteriaId)->update([
                            'criteria_id' => $criteriaId,
                            'name' => $request->input('criteria_name.' . $criteriaId),
                            'candidate_name' => $request['candidate_name'],
                            'voter_name' => $request['voter_name'],
                            'rate' => $averageRate,
                        ]);
                    } else {
                        VoterRate::create([
                            'criteria_id' => $criteriaId,
                            'name' => $request->input('criteria_name.' . $criteriaId),
                            'candidate_name' => $request['candidate_name'],
                            'voter_name' => $request['voter_name'],
                            'rate' => $averageRate,
                        ]);
                    }
                } else {
                    VoterRate::create([
                        'criteria_id' => $criteriaId,
                        'name' => $request->input('criteria_name.' . $criteriaId),
                        'candidate_name' => $request['candidate_name'],
                        'voter_name' => $request['voter_name'],
                        'rate' => $averageRate,
                    ]);
                    // Update the database for the specific criteria
                    ManageCriteria::where('id', $criteriaId)->update([
                        'rate' => $averageRate,
                    ]);
                }
            }
        }

        return redirect('/voter/rateCandidate/student-warefare');
    }
}
