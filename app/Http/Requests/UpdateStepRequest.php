<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStepRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan otorisasi Anda
    }

    public function rules(): array
    {
        return [
            'no_iwo' => 'required|uuid',
            'is_completed' => 'required|boolean',
            'keterangan' => 'nullable|string',
        ];
    }
}
