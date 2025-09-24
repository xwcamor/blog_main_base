<?php

// Source folder: app\Http\Controllers\AuthManagement\Auth\
namespace App\Http\Controllers\AuthManagement\Auth;

// Allow to use subfolders
use App\Http\Controllers\Controller;

// Use Illuminates
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Main class
class LoginController extends Controller
{   
    // ------------------------------
    // Login
    // ------------------------------
    public function login()
    {
        // Show login form
        return view('auth_management.auth.login');
    }
    
    // Login Access
    public function loginAccess(Request $request)
    {
        // Validate input
        $credentials = $request->only('email', 'password');
        
        // Attempt to authenticate
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent fixation
            $request->session()->regenerate();
            
            // Redirect to User Dashboard
            return redirect()
                   ->route('dashboard_management.dashboards.index')
                   ->with('success', __('auth.start_session'));
        }

        // Redirect back with error
        return redirect()->back()
                   ->withInput()
                   ->with('error', __('auth.error_session'));
    }

    // ------------------------------
    // Logout
    // ------------------------------
    public function logout(Request $request)
    {
        // Perform logout
        Auth::logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to login with success message
        return redirect()
                   ->route('login')
                   ->with('success', __('auth.end_session'));
    }

    // ------------------------------
    // API Login
    // ------------------------------
    public function apiLogin(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // Generate unique API token if not exists
            if (!$user->api_token) {
                $user->api_token = 'sk-or-v1-' . \Illuminate\Support\Str::random(64);
                $user->save();
            }

            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'api_token' => $user->api_token,
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
}