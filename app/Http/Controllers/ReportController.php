<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //Display all report
    public function index()
    {
        $report = Report::all();
        return view(
            'report.view_report',
            ['report' => $report],
        );
    }
}
