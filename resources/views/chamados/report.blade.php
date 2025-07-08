<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ordem de serviço #{{ $chamado->id }}</title>
    <style>
        /* Define fontes e cores básicas */
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 10px; /* Reduzido de 11px para 10px */
            line-height: 1.4; /* Ajustado para um pouco mais compacto */
            color: #000;
            background-color: #fff;
            margin: 0;
        }

        /* Cabeçalho do Documento */
        .header {
            background-color: #e0e6ed; /* Escurecido de #f8fafc (slate-50) */
            padding: 5px; /* Reduzido de 20px */
            text-align: center;
            border-bottom: 2px solid #aeb7c2; /* Escurecido de #e2e8f0 (slate-200) */
        }
        .header img {
            max-height: 50px; /* Reduzido de 60px */
            margin-bottom: 8px; /* Reduzido de 10px */
        }
        .header h1 {
            margin: 0;
            font-size: 20px; /* Reduzido de 22px */
            color: #1e293b; /* Cor cinza-escuro (slate-800) */
        }
        .header h2 {
            margin: 4px 0 0; /* Reduzido de 5px */
            font-size: 14px; /* Reduzido de 16px */
            font-weight: normal;
            color: #475569; /* Cor cinza (slate-600) */
        }

        /* Corpo do Relatório */
        .content {
            padding: 10px; /* Reduzido de 25px */
        }

        /* Estilo das Seções */
        .section {
            margin-bottom: 10px; /* Reduzido de 25px */
            page-break-inside: avoid; /* Tenta não quebrar a seção no meio da página */
        }
        .section-header {
            background-color: #fff;
            color: #000;
            padding: 5px; /* Reduzido de 8px 12px */
            font-size: 13px; /* Reduzido de 14px */
            font-weight: bold;
            border-radius: 4px;
        }

        /* Tabelas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px; /* Reduzido de 10px */
        }
        th, td {
            border: 1px solid #94a3b8; /* Escurecido de #e2e8f0 (slate-200) */
            padding: 6px 8px; /* Reduzido de 8px 10px */
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #cbd5e1; /* Escurecido de #f1f5f9 (slate-100) */
            font-weight: bold;
        }

        /* Tabela de Detalhes Específica */
        .details-table td:first-child {
            font-weight: bold;
            width: 25%;
            background-color: #e0e6ed; /* Escurecido de #f8fafc (slate-50) */
        }

        /* Tabela de Logs (Chat e Histórico) */
        .log-table .date { width: 100px; } /* Ajustado para otimizar espaço */
        .log-table .author { width: 120px; } /* Ajustado para otimizar espaço */
        .log-table p, .details-table p { margin: 0; }

        /* Tratamento de quebra de linha */
        .preserve-lines {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Estilos para as assinaturas */
        .signatures-section {
            margin-top: 40px; /* Reduzido de 50px */
            padding: 20px; /* Reduzido de 25px */
            text-align: center;
            page-break-before: auto;
            page-break-inside: avoid;
        }

        .signature-block {
            display: inline-block;
            width: 45%;
            margin: 0 2%;
            vertical-align: top;
            text-align: center;
        }

        .signature-line {
            width: 100%;
            border-bottom: 1px solid #000;
            height: 1px;
            margin-bottom: 4px; /* Reduzido de 5px */
        }

        .signature-text {
            font-size: 9px; /* Reduzido de 10px */
            font-weight: bold;
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>

    <header class="header">
        <img src="{{ public_path('logo.png') }}" alt="Logo">
        <h1>Ordem de Serviço</h1>
        <h2>Chamado #{{ $chamado->id }}: {{ $chamado->titulo }}</h2>
    </header>

    <main class="content">

        <section class="section">
            <div class="section-header">Detalhes do Chamado</div>
            <table class="details-table">
                <tr><td>Status</td><td>{{ $chamado->status->value }}</td></tr>
                <tr><td>Local</td><td>{{ $chamado->local ?? 'Não informado' }}</td></tr>
                <tr><td>Departamento</td><td>{{ $chamado->departamento->nome ?? 'Não informado' }}</td></tr>
                <tr><td>Solicitante</td><td>{{ $chamado->solicitante->name ?? 'N/A' }}</td></tr>
                <tr><td>Técnico</td><td>{{ $chamado->tecnico->name ?? 'Não atribuído' }}</td></tr>
                <tr>
                    <td>Datas</td>
                    <td>
                        Aberto em: {{ $chamado->created_at->format('d/m/Y H:i') }}
                        @if($chamado->data_fechamento)
                            Fechado em: {{ $chamado->data_fechamento->format('d/m/Y H:i') }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Descrição do Problema</td>
                    <td class="preserve-lines">{{ $chamado->problema->descricao }}</td>
                </tr>
                @if($chamado->solucao_final)
                    <tr>
                        <td>Solução Final</td>
                        <td class="preserve-lines">{{ $chamado->solucao_final }}</td>
                    </tr>
                @endif
            </table>
        </section>

        <section class="section">
            <div class="section-header">Histórico de Eventos</div>
            <table class="log-table">
                <thead><tr><th class="date">Data</th><th>Evento</th></tr></thead>
                <tbody>
                    @forelse ($historyLogs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="preserve-lines">{{ $log->texto }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" style="text-align: center;">Nenhum evento registrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

    </main>

    {{-- Seção de Assinaturas --}}
    <div class="signatures-section">
        <div class="signature-block">
            <div class="signature-line"></div>
            <div class="signature-text">Assinatura do técnico responsável</div>
        </div>
        <div class="signature-block">
            <div class="signature-line"></div>
            <div class="signature-text">Assinatura do atendido</div>
        </div>
    </div>

</body>
</html>
