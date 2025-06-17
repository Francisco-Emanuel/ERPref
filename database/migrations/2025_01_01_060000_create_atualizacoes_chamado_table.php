<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('atualizacoes_chamado', function (Blueprint $table) {
            $table->id();
            $table->text('texto');
            // --- CHAVES ESTRANGEIRAS ---
            $table->foreignId('chamado_id')
                  ->constrained('chamados')
                  ->onDelete('cascade'); // Se o chamado for deletado, suas atualizações também serão.
            $table->foreignId('autor_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Se o usuário autor for deletado, suas atualizações também serão.
            $table->timestamps(); // Cria 'created_at' (nossa data_hora) e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atualizacoes_chamado');
    }
};
