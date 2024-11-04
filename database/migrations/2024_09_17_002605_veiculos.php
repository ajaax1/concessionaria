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
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 160);
            $table->foreignId('marca_id')->constrained('marcas');
            $table->string('modelo',160);
            $table->integer('ano');
            $table->string('cor',10);
            $table->decimal('preco',10,2);
            $table->text('descricao');
            $table->enum('status',['USADO','NOVO','SEMINOVO']);
            $table->decimal('quilometragem',10,3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
