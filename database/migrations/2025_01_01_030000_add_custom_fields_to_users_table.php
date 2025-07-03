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
        Schema::table('users', function (Blueprint $table) {
            $table->after('password', function ($table) {
                $table->string('especialidade', 50)->nullable();
                
                $table->foreignId('departamento_id')
                      ->nullable()
                      ->constrained('departamentos') 
                      ->onDelete('set null');  
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
            $table->dropForeign(['departamento_id']);
            // Depois remove as colunas
            $table->dropColumn(['departamento_id', 'especialidade']);
        });
    }
};