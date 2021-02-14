<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'telephone' => 'required|numeric|unique:users',
            'password' => 'required',
            'address.street' => 'required',
            'address.house_number' => 'required',
            'address.zip_code' => 'required',
            'address.city' => 'required',
            'payment_infos.account_owner' => 'required',
            'payment_infos.iban' => 'required|unique:payment_infos',
        ];
    }
}
