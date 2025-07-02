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
        Schema::table('articles', function (Blueprint $table) {
            // Ajouter la colonne code_article si elle n'existe pas
            if (!Schema::hasColumn('articles', 'code_article')) {
                $table->string('code_article')->unique();
            }
        });

        // Supprimer la clé primaire existante
        \DB::statement('ALTER TABLE articles DROP PRIMARY KEY');

        // Définir code_article comme clé primaire
        \DB::statement('ALTER TABLE articles ADD PRIMARY KEY (code_article)');

        // (Optionnel) Supprimer la colonne id si elle existe
        if (Schema::hasColumn('articles', 'id')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->dropColumn('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ajouter la colonne id (auto-incrément) si besoin lors du rollback
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'id')) {
                $table->bigIncrements('id');
            }
        });
        // Supprimer la clé primaire sur code_article
        \DB::statement('ALTER TABLE articles DROP PRIMARY KEY');
        // Remettre la clé primaire sur id
        \DB::statement('ALTER TABLE articles ADD PRIMARY KEY (id)');
    }
}; 