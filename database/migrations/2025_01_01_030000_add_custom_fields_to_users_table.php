<?php

// Arquivo: database/migrations/YYYY_MM_DD_HHMMSS_add_custom_fields_to_users_table.php

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
        // Usamos Schema::table() para MODIFICAR uma tabela que já existe
        Schema::table('users', function (Blueprint $table) {
            // Opcional: define onde as novas colunas devem ser inseridas
            $table->after('password', function ($table) {
                $table->string('especialidade', 50)->nullable();
                
                // Agora é o momento certo para adicionar a chave estrangeira,
                // pois a tabela 'setores' já terá sido criada por sua própria migration.
                $table->foreignId('setor_id')
                      ->nullable()
                      ->constrained('setores') // Liga à tabela 'setores'
                      ->onDelete('set null');  // Se um setor for deletado, este campo fica nulo
            });
        });
    }

    /**
     * Reverse the migrations.
     * (O 'down' desfaz o que o 'up' fez)
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove a chave estrangeira primeiro
            $table->dropForeign(['setor_id']);
            // Depois remove as colunas
            $table->dropColumn(['setor_id', 'especialidade']);
        });
    }
};