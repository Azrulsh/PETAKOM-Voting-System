<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use Illuminate\Http\Request;

class RateCandidateController extends Controller
{
    // Display All Candidate
    public function index()
    {
        $candidates = ManageCandidate::all();
        return view(
            'manage_candidate.view_rate_candidate',
            ['candidates' => $candidates],
        );
    }
}
