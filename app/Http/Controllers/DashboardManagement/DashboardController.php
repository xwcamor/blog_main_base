<?php

// Namespace
namespace App\Http\Controllers\DashboardManagement;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\User;
 
// Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// Main class
class DashboardController extends Controller
{
    // Action Index
    public function index(Request $request)
    {
       
        // Return data to index
        return view('dashboard_management.dashboards.index');
    }
}