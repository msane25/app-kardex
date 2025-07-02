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
        // 1. Supprimer la clé étrangère existante sur codeArticle (si elle existe)
        Schema::table('mouvements', function (Blueprint $table) {
            if (Schema::hasColumn('mouvements', 'codeArticle')) {
                try {
                    $table->dropForeign(['codeArticle']);
                } catch (\Exception $e) {}
            }
        });

        // 2. Renommer la colonne
        if (Schema::hasColumn('mouvements', 'codeArticle')) {
            Schema::table('mouvements', function (Blueprint $table) {
                $table->renameColumn('codeArticle', 'code_article');
            });
        }

        // 3. Ajouter la nouvelle clé étrangère
        Schema::table('mouvements', function (Blueprint $table) {
            if (Schema::hasColumn('mouvements', 'code_article')) {
                try {
                    $table->foreign('code_article')->references('code_article')->on('articles')->onDelete('cascade');
                } catch (\Exception $e) {}
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Supprimer la clé étrangère sur code_article
        Schema::table('mouvements', function (Blueprint $table) {
            if (Schema::hasColumn('mouvements', 'code_article')) {
                try {
                    $table->dropForeign(['code_article']);
                } catch (\Exception $e) {}
            }
        });

        // 2. Renommer la colonne dans l'autre sens
        if (Schema::hasColumn('mouvements', 'code_article')) {
            Schema::table('mouvements', function (Blueprint $table) {
                $table->renameColumn('code_article', 'codeArticle');
            });
        }
    }
}; 