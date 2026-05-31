<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('login');
    }

    public function register(): View
    {
        return view('register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        Auth::login($user);

        return redirect()
            ->route('dashboard.index')
            ->with('success', 'Conta criada com sucesso.');
    }

    public function authentication(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', trim($request->email))
            ->where('is_active', true)
            ->first();

        if ($user && Hash::check(trim($request->password), $user->password)) {
            Auth::login($user);

            return redirect()->route('dashboard.index');
        }

        return redirect()
            ->back()
            ->with('error', 'Login inválido.');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect()->route('login');
    }
}
