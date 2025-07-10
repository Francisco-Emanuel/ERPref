<?php

namespace App\Http\Requests\Chamado;

use Illuminate\Foundation\Http\FormRequest;

class ResolveChamadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // A autorização já é verificada no controller, mas podemos mantê-la aqui também
        return $this->user()->can('close-chamados');
    }

    public function rules(): array
    {
        return [
            'solucao_final' => 'required|string|min:10',
            'servico_executado' => 'accepted',
            'assinatura_tecnico' => 'required|string',
            'assinatura_solicitante' => 'required|string',
        ];
    }
}