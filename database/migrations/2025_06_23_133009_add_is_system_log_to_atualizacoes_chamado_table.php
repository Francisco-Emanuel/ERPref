<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atualizacoes_chamado', function (Blueprint $table) {
            // Adiciona a coluna depois da coluna 'texto'
            // Por padrão, toda nova entrada será 'false' (ou seja, uma mensagem de chat)
            $table->boolean('is_system_log')->default(false)->after('texto');
        });
    }

    public function down(): void
    {
        Schema::table('atualizacoes_chamado', function (Blueprint $table) {
            $table->dropColumn('is_system_log');
        });
    }
};