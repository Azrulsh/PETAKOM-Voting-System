<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\Secretary;
use App\Models\SportsExco;
use App\Models\StudentWarefare;
use App\Models\Rating;
use App\Models\WelfareExco;

class ReportController extends Controller
{
    //Display all report
    public function index()
    {
        $criterias = Criterion::all();
        $candidates = Candidate::all();
        $totalStudentWarefare = StudentWarefare::all();
        $totalWelfareExco = WelfareExco::all();
        $totalSportsExco = SportsExco::all();
        $totalSecretary = Secretary::all();
        return view(
            'report.view_all_voter_report',
            compact([
                'criterias',
                'candidates',
                'totalStudentWarefare',
                'totalWelfareExco',
                'totalSportsExco',
                'totalSecretary',
            ]),
        );
    }

    public function display()
    {
        $criterias = Criterion::all();
        $candidates = Candidate::all();
        $voterRate = Rating::all();
        $totalStudentWarefare = StudentWarefare::all();
        $totalWelfareExco = WelfareExco::all();
        $totalSportsExco = SportsExco::all();
        $totalSecretary = Secretary::all();
        return view(
            'report.view_generate_report',
            compact(
                [
                    'criterias',
                    'voterRate',
                    'candidates',
                    'totalStudentWarefare',
                    'totalWelfareExco',
                    'totalSportsExco',
                    'totalSecretary',
                ],
            )
        );
    }
}
