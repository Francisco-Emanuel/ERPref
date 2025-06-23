<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('problemas', function (Blueprint $table) {
            $table->id();
            $table->text('descricao'); // A descrição detalhada do problema

            // Chave estrangeira para o Ativo de TI ao qual o problema pertence
            $table->foreignId('ativo_ti_id')
                ->nullable()
                ->constrained('ativos_ti')
                ->onDelete('cascade'); // Se o ativo for deletado, seus problemas também são

            // Chave estrangeira para o Usuário que reportou o problema
            $table->foreignId('autor_id')
                ->constrained('users')
                ->onDelete('cascade'); // Se o autor for deletado, seus relatos também são

            $table->timestamps(); // Cria created_at (nossa data_ocorrencia) e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problemas');
    }
};