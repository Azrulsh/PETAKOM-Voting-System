<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\Secretary;
use App\Models\SportsExco;
use App\Models\StudentWarefare;
use App\Models\WelfareExco;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    //Display all result
    public function index()
    {
        $studentWarefare = StudentWarefare::all();
        $welfareExco = WelfareExco::all();
        $sportsExco = SportsExco::all();
        $secretary = Secretary::all();
        $candidates = ManageCandidate::all();

        $swMaxValue = StudentWarefare::max('rate');
        $weMaxValue = WelfareExco::max('rate');
        $seMaxValue = SportsExco::max('rate');
        $sMaxValue = Secretary::max('rate');

        $candidateNameSW = null;
        $candidateIdSW = null;
        $candidateNameWE = null;
        $candidateIdWE = null;
        $candidateNameSE = null;
        $candidateIdSE = null;
        $candidateNameS = null;
        $candidateIdS = null;

        foreach ($studentWarefare as $student) {
            if ($student->rate == $swMaxValue) {
                $candidateNameSW = $student->candidate_name;
                foreach ($candidates as $candidate) {
                    if ($candidate->full_name == $student->candidate_name) {
                        $candidateIdSW = $candidate->matric_id;
                        // Break out of the loop once the first record with the maximum 'rate' is found
                        break;
                    }
                }
                // Break out of the loop once the first record with the maximum 'rate' is found
                break;
            }
        }

        foreach ($welfareExco as $student) {
            if ($student->rate == $weMaxValue) {
                $candidateNameWE = $student->candidate_name;
                foreach ($candidates as $candidate) {
                    if ($candidate->full_name == $student->candidate_name) {
                        $candidateIdWE = $candidate->matric_id;
                        // Break out of the loop once the first record with the maximum 'rate' is found
                        break;
                    }
                }
                // Break out of the loop once the first record with the maximum 'rate' is found
                break;
            }
        }

        foreach ($sportsExco as $student) {
            if ($student->rate == $seMaxValue) {
                $candidateNameSE = $student->candidate_name;
                foreach ($candidates as $candidate) {
                    if ($candidate->full_name == $student->candidate_name) {
                        $candidateIdSE = $candidate->matric_id;
                        // Break out of the loop once the first record with the maximum 'rate' is found
                        break;
                    }
                }
                // Break out of the loop once the first record with the maximum 'rate' is found
                break;
            }
        }

        foreach ($secretary as $student) {
            if ($student->rate == $sMaxValue) {
                $candidateNameS = $student->candidate_name;
                foreach ($candidates as $candidate) {
                    if ($candidate->full_name == $student->candidate_name) {
                        $candidateIdS = $candidate->matric_id;
                        // Break out of the loop once the first record with the maximum 'rate' is found
                        break;
                    }
                }
                // Break out of the loop once the first record with the maximum 'rate' is found
                break;
            }
        }

        return view(
            'report.view_result',
            compact([
                'candidateNameSW',
                'candidateIdSW',
                'candidateNameWE',
                'candidateIdWE',
                'candidateNameSE',
                'candidateIdSE',
                'candidateNameS',
                'candidateIdS',
            ]),
        );
    }
}
