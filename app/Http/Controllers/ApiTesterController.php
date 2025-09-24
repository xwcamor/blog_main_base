<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTesterController extends Controller
{
    public function index()
    {
        return view('api_tester.index');
    }
}
