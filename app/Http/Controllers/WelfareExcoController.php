<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use App\Models\VoterRate;
use App\Models\WelfareExco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelfareExcoController extends Controller
{

    // Display All Candidate of Welfare Exco
    public function display()
    {
        $criterias = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        $voterRate = VoterRate::all();
        return view(
            'manage_candidate.view_all_welfareExco_candidate',
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
            $candidateName = VoterRate::where('criteria_id', $criteriaId)->value('candidate_name');

            if ($request->input('candidate_name') == $candidateName) {
                $rateValueDB = WelfareExco::where('id', $criteriaId)->value('rate');
                $initialRate = WelfareExco::where('id', $criteriaId)->value('rate');
            } else {
                $initialRate = 0.0;
                $rateValueDB = 0.0;
            }

            // Ensure $rateValue is a numeric value before division
            $rateValueDouble = floatval($rateValueInput);

            // Calculate the new average rate
            $averageRate = ($rateValueDouble + $initialRate) / $numberVoterDouble; // Assuming you are adding a new vote

            $totalAverageRate = ($rateValueDouble + $rateValueDB) / $numberVoterDouble;

            // Check if $averageRate is greater than or equal to 0 before updating the database
            if ($averageRate >= 0) {

                if ($voterName == null) {
                    if ($voterName == null) {
                        // Update the database for the initial total average Welfare Exco
                        WelfareExco::where('id', $criteriaId)->update([
                            'criteria_id' => $criteriaId,
                            'rate' => $totalAverageRate,
                        ]);

                        // Update the database for the initial specific criteria
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

                    if ($request->input('candidate_name') == $candidateName) {
                        // Update the database for the Welfare Exco total Average
                        WelfareExco::where('id', $criteriaId)->update([
                            'criteria_id' => $criteriaId,
                            'rate' => $totalAverageRate,
                        ]);
                    } else {
                        // Update the database for the Welfare Exco total Average
                        WelfareExco::create([
                            'criteria_id' => $criteriaId,
                            'name' => $request->input('criteria_name.' . $criteriaId),
                            'rate' => $averageRate,
                        ]);
                    }
                }
            }
        }

        return redirect('/voter/rateCandidate/welfare-exco');
    }
}
