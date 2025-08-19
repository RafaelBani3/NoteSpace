<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show Login Page
    public function showLogin(){
        return view('auth.login');
    }

    // Logic Authentikasi Login
    public function login(Request $request){
        
        // Log Info : Data User yang masuk
        Log::info('User attempting login:', ['Username' => $request->username]);

        // Validasi data User
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required|min:5',
        ]);

        // Log Info Hasil Validasi data user
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
           
            Session::put('lastActivityTime', time());

            // Log Info : User Berhasil Login
            Log::info('Login Successful', ['Username' => $request->username]);
            
            return redirect()->route('notes.dashboard')->with('success', 'Login Successful!');
        }

        // Log Info : User Berhasil Login
        Log::info('Login Successful', ['Username' => $request->username]);

        return back()->withErrors([
            
            'username' => 'Username or password is incorrect.',
        ])->with('error', 'Username or password is incorrect.');

    }

    // Logout
    public function logout(Request $request)
    {
        $username = Auth::check() ? Auth::user()->username : null;

        Auth::logout();
        Session::flush();

        Log::info('Logout Success', [
            'username' => $username,
            'ip' => $request->ip(),
            'time' => now()->toDateTimeString(),
        ]);

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

}
