<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('projects.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = trim($request->input('login'));
        $password = $request->input('password');

        // Check if login is email or name (Username)
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $field => $loginInput,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('projects.index'))->with('success', 'Logged in successfully!');
        }

        // Fallback check if user typed 'admin' case-insensitively or typed email when field was name
        if ($field === 'name') {
            $user = User::where('name', 'LIKE', $loginInput)->first();
            if ($user && Auth::attempt(['email' => $user->email, 'password' => $password], $request->has('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('projects.index'))->with('success', 'Logged in successfully!');
            }
        }

        return back()->withErrors([
            'login' => 'Invalid Username/Email or Password.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
