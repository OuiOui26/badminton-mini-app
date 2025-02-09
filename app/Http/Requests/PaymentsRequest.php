<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentsRequest extends FormRequest
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
            'court_hours' => 'required|integer|min:1',
            'court_rate' => 'required|numeric|min:0',
            'shuttle_num' => 'required|integer|min:0',
            'shuttle_rate' => 'required|numeric|min:0',
            'players' => ['required', 'array', 'min:1'], 
            'players.*' => ['exists:players,id'], 
        ];
    }
}
