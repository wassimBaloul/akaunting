<?php

namespace App\Http\Controllers\Auth;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Auth\Login as Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;

class Login extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy','logout']);
    }

    public function create()
    {
        return view('auth.login.create');
    }

    public function store(Request $request)
    {
        // Attempt to log in the user
        if (!auth()->attempt($request->only('email', 'password'), $request->get('remember', false))) {
            return response()->json([
                'status' => null,
                'success' => false,
                'error' => true,
                'message' => trans('auth.failed'),
                'data' => null,
                'redirect' => null,
            ]);
        }
    
        // Get the authenticated user
        $user = auth()->user();
    
        // Check if the user is enabled
        if (!$user->enabled) {
            auth()->logout();
    
            return response()->json([
                'status' => null,
                'success' => false,
                'error' => true,
                'message' => trans('auth.disabled'),
                'data' => null,
                'redirect' => null,
            ]);
        }
    
        // Redirect directly to the home page
        $redirectUrl = route('index'); // Ensure your `index` route exists in `web.php`
    
        return response()->json([
            'status' => null,
            'success' => true,
            'error' => false,
            'message' => trans('auth.login_redirect'),
            'data' => null,
            'redirect' => $redirectUrl,
        ]);
    }

    public function destroy()
    {
        $this->logout();

        return redirect()->route('login');
    }

    public function logout()
    {
        auth()->logout();

        // Session destroy is required if stored in database
        if (config('session.driver') == 'database') {
            $request = app('Illuminate\Http\Request');

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->getHandler()->destroy($request->session()->getId());
        }
    }
}
