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
            font-size: 11px;
            color: #000;
            background-color: #fff;
            margin: 0;
        }

        /* Cabeçalho do Documento */
        .header {
            background-color: #e0e6ed; /* Escurecido de #f8fafc (slate-50) */
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #aeb7c2; /* Escurecido de #e2e8f0 (slate-200) */
        }
        .header img {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #1e293b; /* Cor cinza-escuro (slate-800) */
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: normal;
            color: #475569; /* Cor cinza (slate-600) */
        }

        /* Corpo do Relatório */
        .content {
            padding: 25px;
        }

        /* Estilo das Seções */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid; /* Tenta não quebrar a seção no meio da página */
        }
        .section-header {
            background-color: #fff; /* Mantido branco para contraste com o texto preto */
            color: #000;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
        }

        /* Tabelas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #94a3b8; /* Escurecido de #e2e8f0 (slate-200) */
            padding: 8px 10px;
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
        .log-table .date { width: 120px; }
        .log-table .author { width: 150px; }
        .log-table p, .details-table p { margin: 0; }

        /* Tratamento de quebra de linha */
        .preserve-lines {
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        /* Estilos para as assinaturas */
        .signatures-section {
            margin-top: 50px; /* Espaçamento do conteúdo acima */
            padding: 25px;
            text-align: center; /* Centraliza os blocos de assinatura */
            page-break-before: auto; /* Tenta não quebrar a página antes, se houver espaço */
            page-break-inside: avoid; /* Evita quebra dentro da seção */
        }

        .signature-block {
            display: inline-block; /* Coloca os blocos lado a lado */
            width: 45%; /* Largura para cada bloco de assinatura */
            margin: 0 2%; /* Espaçamento entre os blocos */
            vertical-align: top; /* Alinha os blocos pelo topo */
            text-align: center; /* Centraliza o conteúdo dentro de cada bloco */
        }

        .signature-line {
            width: 100%; /* A linha ocupa a largura total do seu bloco pai */
            border-bottom: 1px solid #000; /* Linha preta */
            height: 1px; /* Garante que a linha apareça, mesmo que vazia */
            margin-bottom: 5px; /* Espaço entre a linha e o texto abaixo */
        }

        .signature-text {
            font-size: 10px;
            font-weight: bold;
            color: #333;
            text-align: center; /* Garante que o texto esteja centralizado abaixo da linha */
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
                <tr><td>Data de Abertura</td><td>{{ $chamado->created_at->format('d/m/Y H:i') }}</td></tr>
                @if($chamado->data_fechamento)
                    <tr><td>Data de Fechamento</td><td>{{ $chamado->data_fechamento->format('d/m/Y H:i') }}</td></tr>
                @endif
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
                <tr><td>Observações</td><td><br/><br/><br/><br/></td></tr>
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
