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
                  ->onDelete('cascade'); 
            $table->foreignId('autor_id')
                  ->constrained('users')
                  ->onDelete('cascade'); 
            $table->timestamps(); 
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
