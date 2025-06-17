<?php

namespace App\Http\Controllers;

use App\Models\akun_mekanik;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AddMekanikPmController extends Controller
{
    public function index()
    {
        $credentials = akun_mekanik::where('role', '!=', 'superadmin')->get();
        return view('mekanik-pm', compact('credentials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:16|min:16|unique:credentials,nik',
            'role' => 'required|in:mekanik,pm,ppc',
        ]);

        akun_mekanik::create([
            'id_credentials' => Str::uuid(),
            'name' => $request->name,
            'nik' => $request->nik,
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id_credentials)
    {
        $credential = akun_mekanik::findOrFail($id_credentials);
        return view('edit-mekanik-pm', compact('credential'));
    }

    public function update(Request $request, $id_credentials)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('credentials')->ignore($id_credentials, 'id_credentials')
            ]
        ]);

        akun_mekanik::where('id_credentials', $id_credentials)->update([
            'name' => $request->name,
            'nik' => $request->nik,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id_credentials)
    {
        $credential = akun_mekanik::findOrFail($id_credentials);
        $credential->delete();

        return redirect()->route('add-mekanik-PM')->with('success', 'Akun berhasil dihapus');
    }
}
