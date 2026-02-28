<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()
            ->can('create', [Venta::class, $this->all()]);
    }
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_cliente' => 'string|max:255',
            'tipo' => 'required|string|in:CONTADO,CREDITO',
            'fecha' => 'required|date',
            'enganche' => 'numeric|min:0',
            'total' => 'required|numeric|min:0',
            'sistema' => 'required|string|in:penjamo,juventino,martin',
            'almacen_id' => 'required|exists:almacenes,id',
            'user_vendedor_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [

            'tipo.required' => 'El tipo de venta es obligatorio.',
            'fecha.required' => 'La fecha es obligatoria.',
            'enganche.required' => 'El enganche es obligatorio.',
            'total.required' => 'El total es obligatorio.',
            'sistema.required' => 'El sistema es obligatorio.',
            'almacen_id.required' => 'El almacén es obligatorio.',
            'almacen_id.exists' => 'El almacén no existe.',
            'user_vendedor_id.required' => 'El vendedor es obligatorio.',
            'user_vendedor_id.exists' => 'El ID del vendedor no existe.',
        ];
    }

}
