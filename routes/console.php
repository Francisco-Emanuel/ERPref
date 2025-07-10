<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; 

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's I/O methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::command('app:check-sla-breaches')->everyFiveMinutes();

// --- REGRAS DE BACKUP ---

// 1. Faz o backup do banco de dados às 12:00 e 17:00, apenas nos dias de semana.
Schedule::command('backup:run --only-db')
         ->twiceDaily(12, 17)
         ->weekdays();

// 2. Limpa os backups antigos (com mais de 7 dias) uma vez por dia, às 18:00, apenas nos dias de semana.
Schedule::command('backup:clean')
         ->dailyAt('18:00')
         ->weekdays();