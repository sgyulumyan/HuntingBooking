<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tour_name' => ['required', 'string', 'max:255'],
            'hunter_name' => ['required', 'string', 'max:255'],
            'guide_id' => ['required', 'integer', 'exists:guides,id'],
            'date' => ['required', 'date'],
            'participants_count' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
