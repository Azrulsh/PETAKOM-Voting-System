<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Display data from DB
    public function index(){
        $data = User::all();
        return view('home',['data' => $data]);
    }
}
