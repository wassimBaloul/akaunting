<?php

namespace App\Http\Controllers\Auth;

use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Abstracts\Http\Controller;
use App\Http\Requests\Auth\Register as Request;

class Register extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest'); // Ensure only guests can access registration
    }

    /**
     * Display the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register.create');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \App\Http\Requests\Auth\Register  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:6',
            ]);

            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'locale' => app()->getLocale(),
                'enabled' => true,
                'landing_page' => '/dashboard',
                'created_from' => $request->ip(),
                'created_by' => null,
            ]);

            // Trigger the Registered event
            event(new Registered($user));

            // Log the user in
            $this->guard()->login($user);

            // Redirect with a success message
            return redirect()->route('dashboard')->with('success', 'Registration successful');
        } catch (\Throwable $e) {
            // Log the error for debugging
            \Log::error('Error creating user: ' . $e->getMessage());

            // Redirect back with a friendly error message
            return redirect()->back()->withErrors(['error' => 'User creation failed. Please try again later.']);
        }
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return auth()->guard();
    }
}
