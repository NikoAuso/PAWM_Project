<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $event_id
 * @property mixed $nome
 * @property mixed $persone
 * @property mixed $etaMedia
 * @property mixed $dettagli
 * @property mixed $fattoDa
 */
class TavoloRequest extends FormRequest
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
            'nome' => 'required|string|min:1|max:255',
            'persone' => 'required|integer|min:1',
            'etaMedia' => 'nullable|string|min:1',
            'dettagli' => 'nullable|string|min:1|max:255',
            'fattoDa' => 'required|string|min:1|max:255'
        ];
    }
}
