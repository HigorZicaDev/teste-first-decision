<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function authentication(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => [
                    'required',
                ],
            ],
            [
                'email.required' => 'O email é um campo obrigatório.',
                'email.email' => 'Por favor digite um endereço de email válido.',
                'password.required' => 'A senha é um campo obrigatório.',
            ]
        );

        $user = User::where('email', trim($request->email))
            ->where('is_active', true)
            ->first();

        if ($user && Hash::check(trim($request->password), $user->password)) {

            Auth::login($user);

            return redirect()->route('dashboard.index');

        } else {
            return redirect()->back()->with('warning', 'Login Inválido.');
        }
    }

    public function logout()
    {
        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        return redirect()->route('login');
    }
}
