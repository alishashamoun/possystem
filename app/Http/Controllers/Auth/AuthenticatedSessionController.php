<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user(); // retrieve the user instance with roles

            $allowedRoles = ['admin', 'manager', 'cashier', 'inventory staff', 'customer'];
            // Check if user has one of the allowed roles
            foreach ($allowedRoles as $role) {
                if ($user->hasRole($role)) {
                    switch ($role) {
                        case 'admin':
                            return redirect()->route('admin.dashboard');
                        case 'manager':
                            return redirect()->route('manager.dashboard');
                        case 'cashier':
                            return redirect()->route('cashier.index');
                        case 'inventory staff':
                            return redirect()->route('inventory.dashboard');
                        case 'customer':
                            return redirect()->route('customer.dashboard');
                    }
                }
            }

            // User does not have the required role, return a 403 error
            abort(403, 'User does not have the right roles.');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
