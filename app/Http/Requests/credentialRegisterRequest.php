<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class credentialRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_mekanik' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email|unique:akun_mekaniks',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_mekanik.required' => 'Nama mekanik harus diisi',
            'username.required' => 'Username harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ];
    }
}
