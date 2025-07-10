<?php

namespace App\Http\Requests\Chamado;

use Illuminate\Foundation\Http\FormRequest;

class AddUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('view-chamados');
    }

    public function rules(): array
    {
        return [
            'texto' => 'required|string|min:3',
        ];
    }
}