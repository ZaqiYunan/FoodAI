<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        \Log::info('Signup attempt with data', [
            'request_all' => $request->all(),
        ]);
        
        // Validate the request data
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:Pengguna,Email_Pengguna',
            'password' => 'required|string|min:8|confirmed',
        ]);

        \Log::info('Validation passed', [
            'username' => $validatedData['username'],
            'email' => $validatedData['email']
        ]);

        try {
            // Create a new user in the database
            $user = Pengguna::create([
                'Nama_Pengguna' => $validatedData['username'],
                'Email_Pengguna' => $validatedData['email'],
                'Password_Pengguna' => Hash::make($validatedData['password']),
                'Role_Pengguna' => 'User', // Default role
                'Tgl_Pembuatan' => now(),
            ]);
            
            \Log::info('User created successfully', [
                'id' => $user->ID_Pengguna,
                'username' => $user->Nama_Pengguna,
                'email' => $user->Email_Pengguna
            ]);

            // Redirect to the sign-in page with a success message
            return redirect('/signin')->with('success', 'Account created successfully! Please sign in.');
        } catch (\Exception $e) {
            // Log the error with additional details
            \Log::error("Error creating account: " . $e->getMessage(), [
                'username' => $validatedData['username'],
                'email' => $validatedData['email'],
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->withErrors(['error' => 'Failed to create account. Please try again.']);
        }
    }

    public function signin(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        \Log::info('Attempting login for username: ' . $validatedData['username']);
        
        // Add more detailed debugging
        $user = Pengguna::where('Nama_Pengguna', $validatedData['username'])->first();
        if ($user) {
            \Log::info('User found in database', [
                'id' => $user->ID_Pengguna,
                'username' => $user->Nama_Pengguna
            ]);
        } else {
            \Log::error('User not found in database');
        }

        // Try multiple authentication approaches
        
        // Approach 1: Using Auth facade directly
        $credentials = [
            'Nama_Pengguna' => $validatedData['username'],
            'password' => $validatedData['password']
        ];
        
        \Log::info('Auth credentials', ['credentials' => $credentials]);
        
        // First attempt with standard Auth
        if (Auth::attempt($credentials)) {
            \Log::info('Login successful for username: ' . $validatedData['username']);

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Get authenticated user
            $user = Auth::user();
            \Log::info('Authenticated user details', [
                'id' => $user->ID_Pengguna,
                'name' => $user->Nama_Pengguna,
                'email' => $user->Email_Pengguna
            ]);
            
            // Store user data in the session
            $request->session()->put('user', [
                'id' => $user->ID_Pengguna,
                'name' => $user->Nama_Pengguna,
                'email' => $user->Email_Pengguna,
                'role' => $user->Role_Pengguna,
            ]);

            // Redirect to the landing page
            return redirect('/landingpage')->with('success', 'Welcome back!');
        }

        \Log::error('Standard Auth attempt failed, trying manual login');
        
        // Approach 2: Try manual authentication as a fallback
        $user = Pengguna::where('Nama_Pengguna', $validatedData['username'])->first();
        
        if ($user && Hash::check($validatedData['password'], $user->Password_Pengguna)) {
            \Log::info('Manual authentication successful');
            
            // Login the user manually
            Auth::login($user);
            
            // Regenerate session
            $request->session()->regenerate();
            
            // Store user data in session
            $request->session()->put('user', [
                'id' => $user->ID_Pengguna,
                'name' => $user->Nama_Pengguna,
                'email' => $user->Email_Pengguna,
                'role' => $user->Role_Pengguna,
            ]);
            
            return redirect('/landingpage')->with('success', 'Welcome back!');
        }

        \Log::error('All login attempts failed for username: ' . $validatedData['username']);

        // Redirect back with an error message
        return redirect()->back()->withErrors(['error' => 'Invalid username or password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out
        $request->session()->invalidate(); // Invalidate the session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/landingpage')->with('success', 'You have been logged out.');
    }
}