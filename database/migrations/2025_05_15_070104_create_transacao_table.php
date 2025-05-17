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
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->integer('remetente_id');
            $table->integer('destinatario');
            $table->string('tipo');
            $table->string('status');
            $table->decimal('valor', 15, 2);
            $table->uuid('uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacao');
    }
};
