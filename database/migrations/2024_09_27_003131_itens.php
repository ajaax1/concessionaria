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
        Schema::table('itens', function (Blueprint $table) {
            $table->dropForeign(['veiculo_id']); // Primeiro, remova a chave estrangeira
            $table->dropColumn('veiculo_id'); // Depois, remova a coluna
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens');
    }
};
