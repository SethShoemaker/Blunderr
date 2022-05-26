<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrgRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'description' => ['nullable', 'max:255'],
            'password' => ['required', 'max:255', 'same:password-confirm'],
            'password-confirm' => ['required', 'max:255', 'same:password'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.same' => 'Passwords do not match',
            'password.same' => 'Passwords do not match',
        ];
    }
}
