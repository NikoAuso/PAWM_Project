<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed $titolo
 * @property mixed $extra
 * @property mixed $date
 * @property mixed $discoteca
 * @property mixed $descrizione
 * @property mixed $prevendite
 */
class EventRequest extends FormRequest
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
     * Function that change the format of the date for
     * the database insertion
     *
     * @param null|string $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $input = parent::all();
        if($input['date'] != null)
            $input['date'] = Carbon::createFromFormat('d/m/Y H:i', $input['date'])->format('Y-m-d H:i:s');

        return $input;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'titolo' => 'string|min:1|max:50',
            'extra' => 'nullable|string|min:1|max:50',
            'date' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:1920-01-01',
            'descrizione' => 'nullable|string|max:5000',
            'discoteca' => 'nullable|in:MAMAMIA,NOIR,MIAMI,DIRETTA INSTAGRAM',
            'prevendite' => 'nullable|integer',
            'active' => 'boolean',
            'isJolly' => 'boolean',
            'pagato' => 'nullable|boolean'
        ];
    }
}
