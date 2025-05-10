<?php

namespace App\Http\Controllers;

use App\Http\Requests\credentialRegisterRequest;
use App\Models\akun_mekanik;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(credentialRegisterRequest $request)
    {
        $mekanik = [
            'id_mekanik' => Str::uuid(),
            'nama_mekanik' => $request->nama_mekanik,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        akun_mekanik::create($mekanik);

        return redirect()->route('login.show')->with('message', 'Registration successful! Please log in.');
    }
}
