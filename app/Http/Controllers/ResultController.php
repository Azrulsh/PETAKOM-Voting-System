<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    //Display all result
    public function index()
    {
        return view(
            'report.view_result',
        );
    }
}
