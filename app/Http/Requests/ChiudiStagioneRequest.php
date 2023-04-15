<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $stagione
 * @property mixed $dettagliChiusura
 */
class ChiudiStagioneRequest extends FormRequest
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
            'stagione' => 'required|string|min:1|max:255',
            'dettagliChiusura' => 'string|min:1|max:255'
        ];
    }
}
