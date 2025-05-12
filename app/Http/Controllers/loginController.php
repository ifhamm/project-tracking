<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\akun_mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class loginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $mekanik = akun_mekanik::where('email', $request->email)->first();

        if ($mekanik && Hash::check($request->password, $mekanik->password)) {
            Session::put('logged_in', true);
            Session::put('id_mekanik', $mekanik->id_mekanik);
            Session::put('email', $mekanik->email);
            return redirect()->route('dashboard_utama');
        }

        return back()->withErrors([
            'message' => 'Email atau password salah'
        ]);
    }
}
