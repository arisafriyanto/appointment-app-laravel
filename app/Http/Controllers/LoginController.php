<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'min:3', 'max:30', 'alpha_num'],
        ]);

        $user = User::whereUsername($credentials['username'])->first();

        if ($user) {
            Auth::login($user);
            return redirect()->intended('/appointments');
        }

        return back()->withErrors([
            'username' => 'Login gagal, periksa kembali!'
        ]);
    }
}
