<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTipoArticuloRequest extends FormRequest
{
     protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()
            ->can('create', [TipoArticulo::class, $this->all()]);
    }
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'precio_contado' => 'required|numeric|min:0',
            'precio_credito' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [

            'nombre.required' => 'El nombre es obligatorio.',
            'precio_contado.required' => 'El precio al contado es obligatorio.',
            'precio_credito.required' => 'El precio a crédito es obligatorio.',
        ];
    }
}
