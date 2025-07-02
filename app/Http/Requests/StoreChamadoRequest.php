<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreChamadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Usamos a mesma lógica de autorização que estava no controller
        return $this->user()->can('create-chamados');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         $user = $this->user();
        // Movemos as regras do controller para cá
        return [
            'titulo' => 'required|string|max:255',
            'descricao_problema' => 'required|string',
            'local' => 'required|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
            'ativo_id' => 'nullable|exists:ativos_ti,id',
            'prioridade' => 'required|string|max:50',
            'categoria_id' => 'nullable|exists:categorias,id',
            'solicitante_id' => [
            Rule::requiredIf(fn () => $user->hasAnyRole(['Admin', 'Supervisor', 'Técnico de TI'])),
            'nullable',
            'exists:users,id'
        ]
        ];
    }
}