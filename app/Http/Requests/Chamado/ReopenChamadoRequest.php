<?php

namespace App\Http\Requests\Chamado;

use Illuminate\Foundation\Http\FormRequest;

class ReopenChamadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Apenas o solicitante do chamado pode reabri-lo
        return $this->user()->id === $this->route('chamado')->solicitante_id;
    }

    public function rules(): array
    {
        return [
            'motivo_reabertura' => 'required|string|min:15',
        ];
    }
}