<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $name
 * @property mixed $surname
 * @property mixed $username
 * @property mixed $email
 * @property mixed $role
 * @property mixed $team
 */
class UserRequest extends FormRequest
{
    /**
     * Determine if the users is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'surname' => 'required|string|min:1|max:255',
            'email' => 'nullable|string|min:1|max:255',
            'role' => 'required|string',
            'team' => 'required|string',
            'active' => 'boolean'
        ];
    }
}
