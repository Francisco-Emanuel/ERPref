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
            $table->string('nome_ativo');
            $table->string('numero_serie')->unique();
            $table->string('tipo_ativo', 50);
            $table->string('status_condicao', 50);
            $table->text('descricao_problema')->nullable();
           $table->foreignId('user_id')
                  ->nullable() 
                  ->constrained('users') 
                  ->onDelete('set null');
                  $table->foreignId('setor_id')
                  ->nullable() 
                  ->constrained('setores') 
                  ->onDelete('set null');
            $table->boolean('visible')->default(true);
            $table->softDeletes();
            $table->timestamps();
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
