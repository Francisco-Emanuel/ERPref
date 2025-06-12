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
            $table->string('identificacao')->unique();
            $table->string('descricao_problema');
            $table->string('tipo_ativo');
            $table->string('setor');
            $table->string('usuario_responsavel');
            $table->boolean('status');
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
