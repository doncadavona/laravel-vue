<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $this->route('user')
            ],
            'email'                => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->route('user')],
            'password'             => ['nullable', 'string', 'min:6', 'confirmed'],

            'first_name'           => ['required', 'string', 'max:255'],
            'last_name'            => ['required', 'string', 'max:255'],
            'address'              => ['nullable', 'string', 'min:1', 'max:255'],
            'postcode'             => ['nullable', 'numeric', 'digits_between:4,6'],
            'contact_phone_number' => ['nullable', 'digits:11', 'max:255', 'unique:users,contact_phone_number,' . $this->route('user')],
        ];
    }
}
