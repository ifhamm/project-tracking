<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoXSS implements Rule
{
    public function passes($attribute, $value)
    {
        // Fail if value contains HTML tags
        return $value === strip_tags($value);
    }

    public function message()
    {
        return 'Input tidak boleh mengandung tag HTML atau script.';
    }
}
