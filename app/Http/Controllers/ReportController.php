<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use App\Models\Secretary;
use App\Models\SportsExco;
use App\Models\StudentWarefare;
use App\Models\VoterRate;
use App\Models\WelfareExco;

class ReportController extends Controller
{
    //Display all report
    public function index()
    {
        $criterias = ManageCriteria::all();
        $candidates = ManageCandidate::all();
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
        $criterias = ManageCriteria::all();
        $candidates = ManageCandidate::all();
        $voterRate = VoterRate::all();
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
