<?php

namespace App\Http\Requests\Chamado;

use App\Enums\ChamadoStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('edit-chamados');
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(ChamadoStatus::class)],
        ];
    }
}