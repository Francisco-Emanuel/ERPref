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
        Schema::table('chamados', function (Blueprint $table) {
            // Adiciona a nova chave estrangeira para a tabela 'problemas'
            $table->foreignId('problema_id')
                  ->unique() // Garante que um problema só possa ter um chamado
                  ->constrained('problemas')
                  ->after('titulo'); // Coloca a coluna depois da coluna 'titulo'

            // Remove a coluna de descrição antiga
            $table->dropColumn('descricao_inicial');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chamados', function (Blueprint $table) {
            // Adiciona a coluna antiga de volta
            $table->text('descricao_inicial')->after('titulo');

            // Remove a chave estrangeira e a coluna nova
            $table->dropForeign(['problema_id']);
            $table->dropColumn('problema_id');
        });
    }
};