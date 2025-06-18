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
            if ($mekanik->role === 'superadmin') {
                Session::put('logged_in', true);
                Session::put('id_mekanik', $mekanik->id_mekanik);
                Session::put('email', $mekanik->email);
                Session::put('role', $mekanik->role);
                return redirect()->route('dashboard_utama');
            } else {
                return back()->withInput(['login_type' => 'superadmin', 'email' => $request->email])->with('error', 'Akun ini bukan superadmin.');
            }
        }

        return back()->withInput(['login_type' => 'superadmin', 'email' => $request->email])->with('error', 'Email atau password salah.');
    }

    public function loginUser(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|min:8'
        ]);

        $mekanik = akun_mekanik::where('nik', $request->nik)->first();

        if ($mekanik) {
            if (in_array($mekanik->role, ['pm', 'mekanik', 'ppc'])) {
                Session::put('logged_in', true);
                Session::put('id_mekanik', $mekanik->id_mekanik);
                Session::put('role', $mekanik->role);
                return redirect()->route('dashboard_utama');
            } else {
                return back()->withInput(['login_type' => 'user', 'nik' => $request->nik])->with('error', 'Akun ini bukan PM, Mekanik, atau PPC.');
            }
        }

        return back()->withInput(['login_type' => 'user', 'nik' => $request->nik])->with('error', 'NIK tidak terdaftar.');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login.show');
    }
}
