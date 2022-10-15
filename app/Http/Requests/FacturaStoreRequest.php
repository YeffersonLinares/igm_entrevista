<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturaStoreRequest extends FormRequest
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
            'emisor_nombre' => 'required',
            'emisor_nit' => 'required',
            'receptor_nombre' => 'required',
            'receptor_nit' => 'required',
            'valor' => 'required|integer',
            'iva' => 'required|integer',
            'valor_total' => 'required|integer'
        ];
    }

    public function attributes()
    {
        return [
            'emisor_nombre' => 'Nombre del emisor',
            'emisor_nit' => 'Nit del emisor',
            'receptor_nombre' => 'Nombre del receptor',
            'receptor_nit' => 'Nombre del receptor',
            'valor_total' => 'Valor Total',
        ];
    }
}
