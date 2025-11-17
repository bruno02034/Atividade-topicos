<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Login didático: usuário fixo
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required','min:3'],
        ]);

        if ($request->email === 'admin@example.com' && $request->password === 'admin') {
            $request->session()->put('logged_in', true);
            $request->session()->flash('success','Login realizado!');
            return redirect()->route('products.index');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas'])->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->forget('logged_in');
        $request->session()->flash('success','Logout realizado!');
        return redirect()->route('login.show');
    }
}