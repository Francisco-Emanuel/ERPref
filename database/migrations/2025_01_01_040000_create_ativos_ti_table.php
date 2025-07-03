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

            $table->foreignId('user_id')
                  ->nullable() 
                  ->constrained('users') 
                  ->onDelete('set null'); 

            $table->foreignId('departamento_id')
                  ->nullable() 
                  ->constrained('departamentos') 
                  ->onDelete('set null'); 

            $table->timestamps(); 
            
            $table->softDeletes(); 

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