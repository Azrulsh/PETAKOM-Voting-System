<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use Illuminate\Http\Request;

class RateCandidateController extends Controller
{
    // Display All Criteria
    public function position()
    {
        return view(
            'manage_candidate.view_rate_candidate',
        );
    }

    // Display All Candidate of Student Warefare
    public function studentWarefare()
    {
        $criteria = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        return view(
            'manage_candidate.view_all_studentWarefare_candidate',
            compact(
                [
                    'candidates',
                    'criteria',
                ],
            ),
        );
    }

    // Display All Candidate of Welfare Exco
    public function welfareExco()
    {
        $criteria = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        return view(
            'manage_candidate.view_all_welfareExco_candidate',
            compact(
                [
                    'candidates',
                    'criteria',
                ],
            ),
        );
    }

    // Display All Candidate of Sports Exco
    public function sportsExco()
    {
        $criteria = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        return view(
            'manage_candidate.view_all_sportsExco_candidate',
            compact(
                [
                    'candidates',
                    'criteria',
                ],
            ),
        );
    }
}
