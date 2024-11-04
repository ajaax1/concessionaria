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
        Schema::table('veiculos', function (Blueprint $table) {
            $table->foreignId('categoria_id')->constrained('categorias');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
