<?php

namespace App\Http\Requests\Chamado;

use Illuminate\Foundation\Http\FormRequest;

class AtribuirChamadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('edit-chamados');
    }

    public function rules(): array
    {
        return [
            'new_tecnico_id' => 'required|exists:users,id',
        ];
    }
}