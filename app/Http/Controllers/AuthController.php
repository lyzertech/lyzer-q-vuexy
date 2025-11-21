<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('name', $request->name)->first();

        if ($user && $user->status !== 'approved') {
            return back()->withErrors([
                'email' => 'Contact LyZer Dev. for activation',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            switch ((int) $user->role_id) {
                case 1: // IT Dev.
                    return redirect('/crm/dashboard');

                case 2: // SuperAdmin
                    return redirect('/admin');

                case 4: // Sales
                case 5: // Sales
                    return redirect('/crm/customer');

                case 6: // Labs Team
                    return redirect('/labs/label');

                case 7: // Monitoring Team
                    return redirect('/monitoring/analysis/realtime');

                case 21: // Teacher
                    return redirect('/student/list');

                default:
                    // fallback kalau role gak dikenal
                    return redirect('/home');
            }
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validatedData['role_id'] = $request->input('role_id', 7);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role_id' => $validatedData['role_id'],
            'password' => Hash::make($validatedData['password']),
            'status' => 'pending', // Default to pending
        ]);

        return redirect('/login')->with('success', 'Account created successfully. Please log in.');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
