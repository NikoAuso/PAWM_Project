<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $list_id
 * @property mixed $event_id
 * @property mixed $name
 * @property mixed $surname
 * @property mixed $quantity
 * @property mixed $entered
 * @property mixed $fatto_da
 */
class ListeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'list_id' => 'integer',
            'event_id' => 'integer',
            'name' => 'string',
            'surname' => 'string',
            'quantity' => 'integer',
            'entered' => 'integer',
            'fatto_da' => 'integer'
        ];
    }
}
