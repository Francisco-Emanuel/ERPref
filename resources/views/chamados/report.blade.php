<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Relatório do Chamado #{{ $chamado->id }}</title>
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
            background-color: #f8fafc; /* Cor cinza-claro (slate-50) */
            padding: 20px;
            text-align: center;
            border-bottom: 2px solid #e2e8f0; /* Cor cinza (slate-200) */
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
            background-color: #fff; /* Cor azul do tema */
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
            border: 1px solid #e2e8f0; /* Cor cinza (slate-200) */
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f1f5f9; /* Cor cinza-claro (slate-100) */
            font-weight: bold;
        }
        
        /* Tabela de Detalhes Específica */
        .details-table td:first-child {
            font-weight: bold;
            width: 25%;
            background-color: #f8fafc; /* Cor cinza-claro (slate-50) */
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
    </style>
</head>
<body>

    <header class="header">
        {{-- Garanta que o seu logo.png esteja na pasta public/ --}}
        <img src="{{ public_path('logo.png') }}" alt="Logo">
        <h1>Relatório de Atendimento</h1>
        <h2>Chamado #{{ $chamado->id }}: {{ $chamado->titulo }}</h2>
    </header>

    <main class="content">

        <section class="section">
            <div class="section-header">Detalhes do Chamado</div>
            <table class="details-table">
                <tr><td>Status</td><td>{{ $chamado->status->value }}</td></tr>
                <tr><td>Local</td><td>{{ $chamado->local }}</td></tr>
                <tr><td>Departamento</td><td>{{ $chamado->departamento }}</td></tr>
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
            </table>
        </section>

        {{-- <section class="section">
            <div class="section-header">Histórico de Conversa (Chat)</div>
            <table class="log-table">
                <thead><tr><th class="date">Data</th><th class="author">Autor</th><th>Mensagem</th></tr></thead>
                <tbody>
                    @forelse ($chatMessages as $message)
                        <tr>
                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $message->autor->name }}</td>
                            <td class="preserve-lines">{{ $message->texto }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" style="text-align: center;">Nenhuma mensagem no chat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section> --}}

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

</body>
</html>
