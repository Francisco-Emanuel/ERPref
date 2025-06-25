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
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao_inicial');
            $table->string('status', 50);
            $table->string('local');
            $table->string('prioridade', 50);
            $table->timestamp('prazo_sla')->nullable();
            $table->timestamp('data_inicio_sla')->nullable();
            $table->text('solucao_final')->nullable();
            $table->timestamp('data_resolucao')->nullable();
            $table->timestamp('data_fechamento')->nullable();
            $table->integer('avaliacao')->nullable();
            // --- CHAVES ESTRANGEIRAS ---
            $table->foreignId('problema_id')
                ->unique() // Garante que um problema só possa ter um chamado
                ->constrained('problemas')
                ->after('titulo');
            $table->foreignId('solicitante_id')
                ->constrained('users')
                ->onDelete('cascade'); // Se o usuário for deletado, seus chamados também são
            $table->foreignId('tecnico_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null'); // Se o técnico for deletado, o campo fica nulo
            $table->foreignId('categoria_id')
                ->nullable()
                ->constrained('categorias')
                ->onDelete('restrict'); // Impede que uma categoria com chamados seja deletada
            $table->foreignId('ativo_id')
                ->nullable()
                ->constrained('ativos_ti')
                ->onDelete('set null'); // Se o ativo for deletado, o campo fica nulo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};
