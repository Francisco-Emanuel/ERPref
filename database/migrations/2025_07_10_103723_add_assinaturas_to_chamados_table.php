<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chamados', function (Blueprint $table) {
            // Adiciona colunas para guardar o caminho dos arquivos de imagem das assinaturas
            $table->string('assinatura_tecnico_path')->nullable()->after('avaliacao');
            $table->string('assinatura_solicitante_path')->nullable()->after('assinatura_tecnico_path');
        });
    }

    public function down(): void
    {
        Schema::table('chamados', function (Blueprint $table) {
            $table->dropColumn(['assinatura_tecnico_path', 'assinatura_solicitante_path']);
        });
    }
};