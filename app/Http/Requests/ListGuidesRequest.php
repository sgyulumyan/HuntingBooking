<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListGuidesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'min_experience' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
