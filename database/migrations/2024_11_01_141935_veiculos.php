<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('veiculos', function (Blueprint $table) {
            $table->dropColumn('cambio');
        });
        Schema::table('veiculos', function (Blueprint $table) {
            $table->enum('cambio', ['Manual', 'Automatico', 'Automatizado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
