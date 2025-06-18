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
        Schema::create('ativos_ti', function (Blueprint $table) {
            $table->id();
            $table->string('nome_ativo', 150);
            $table->string('numero_serie', 100)->unique();
            $table->string('tipo_ativo', 50);
            $table->string('status_condicao', 50);

            // Chave estrangeira para o responsável (User)
            $table->foreignId('user_id')
                  ->nullable() 
                  ->constrained('users') 
                  ->onDelete('set null'); // Se o usuário for deletado, o ativo fica sem responsável

            // Chave estrangeira para o setor
            $table->foreignId('setor_id')
                  ->nullable() 
                  ->constrained('setores') 
                  ->onDelete('set null'); // Se o setor for deletado, o ativo fica sem setor

            $table->timestamps(); // Colunas created_at e updated_at
            
            // ADICIONADO: Esta é a forma correta do Laravel de "ocultar" registros.
            // Ele cria uma coluna 'deleted_at' que funciona como a sua antiga coluna 'visible'.
            $table->softDeletes(); 

            // A coluna 'descricao_problema' foi permanentemente REMOVIDA daqui.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ativos_ti');
    }
};