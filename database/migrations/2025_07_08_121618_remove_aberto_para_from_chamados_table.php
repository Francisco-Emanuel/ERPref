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
            // Remove a coluna 'abertoPara' da tabela 'chamados'
            $table->dropColumn('abertoPara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chamados', function (Blueprint $table) {
            // Adiciona a coluna 'abertoPara' de volta, com as mesmas características originais.
            // É importante que seja do mesmo tipo e com as mesmas restrições (nullable, default, etc.).
            // Se a coluna tinha um `after()` específico, você pode tentar replicar.
            // Assumindo que era uma string não nula, ajuste se for diferente.
            $table->string('abertoPara')->nullable()->after('local'); // Exemplo: se estava depois de 'local'
            // Se você não tem certeza da posição exata, apenas $table->string('abertoPara'); já é suficiente para o rollback funcionar.
        });
    }
};

