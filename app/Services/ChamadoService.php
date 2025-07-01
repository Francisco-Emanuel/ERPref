<?php

namespace App\Services;

use App\Models\Chamado;
use App\Models\Problema;
use App\Models\AtualizacaoChamado;
use App\Enums\ChamadoStatus;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChamadoService
{
    /**
     * Cria um novo problema e um novo chamado associado.
     *
     * @param array $validatedData Dados validados do request.
     * @return Chamado O chamado recém-criado.
     */
    public function criarNovoChamado(array $validatedData): Chamado
    {
        // Lógica para criar o problema primeiro
        $problema = Problema::create([
            'descricao' => $validatedData['descricao_problema'],
            'ativo_ti_id' => $validatedData['ativo_id'] ?? null,
            'autor_id' => Auth::id(),
        ]);

        // Lógica para criar o chamado
        $chamado = Chamado::create([
            'titulo' => $validatedData['titulo'],
            'descricao_inicial' => $validatedData['descricao_problema'],
            'problema_id' => $problema->id,
            'local' => $validatedData['local'],
            'solicitante_id' => $validatedData['solicitante_id'] ?? Auth::id(),
            'status' => ChamadoStatus::ABERTO,
            'prioridade' => $validatedData['prioridade'],
            'categoria_id' => $validatedData['categoria_id'] ?? null,
            'prazo_sla' => null, // SLA começa nulo e é definido na atribuição
            'data_inicio_sla' => null,
            'ativo_id' => $validatedData['ativo_id'] ?? null,
        ]);

        // Cria o log inicial de abertura
        AtualizacaoChamado::create([
            'chamado_id' => $chamado->id,
            'autor_id' => Auth::id(),
            'texto' => 'Chamado aberto.',
            'is_system_log' => true,
        ]);

        return $chamado;
    }
}