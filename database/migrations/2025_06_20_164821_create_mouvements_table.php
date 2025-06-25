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
        Schema::create('mouvements', function (Blueprint $table) {
            $table->id();
            $table->date('date_mouvement');
            $table->string('type_mouvement');
            $table->integer('quantite');
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('operation_id')->constrained()->onDelete('cascade');
            $table->string('destination')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('document_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvements');
    }
};
