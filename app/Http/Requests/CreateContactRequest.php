<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:contacts',
            'phone' => 'required|string|unique:contacts',
            'email' => 'required|string|email|unique:contacts',
            'cep' => 'required|string|size:8'
        ];
    }
}
