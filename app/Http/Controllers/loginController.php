<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\akun_mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function loginSuperAdmin(Request $request)
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
            Session::put('role', $mekanik->role); // Store role in session
            return redirect()->route('dashboard_utama');
        }

        return back()->withErrors([
            'message' => 'Incorrect email or password'
        ]);
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|min:16'
        ]);

        $mekanik = akun_mekanik::where('nik', $request->nik)->first();

        if ($mekanik) {
            Session::put('logged_in', true);
            Session::put('id_mekanik', $mekanik->id_mekanik);
            Session::put('role', $mekanik->role); // Store role in session
            return redirect()->route('dashboard_utama');
        }

        return back()->withErrors([
            'message' => 'NIK not registered'
        ]);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login.show');
    }
}
