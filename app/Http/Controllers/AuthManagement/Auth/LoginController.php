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
                   ->route('auth_management.users.index')
                   ->with('success', 'Sesión iniciada.');
        }

        // Redirect back with error
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Error en las credenciales.');
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
               ->with('success', 'Sesión cerrada.');
    }
}