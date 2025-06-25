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
        Schema::table('mouvements', function (Blueprint $table) {
            $table->string('document_number')->nullable()->after('date_mouvement');
            $table->string('operation')->nullable()->after('document_number');
            $table->string('direction')->nullable()->after('demandeur');
            $table->string('numeroCommande')->nullable()->after('fournisseur');
            $table->string('receptionnaire')->nullable()->after('quantiteServis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mouvements', function (Blueprint $table) {
            $table->dropColumn(['document_number', 'operation', 'direction', 'numeroCommande', 'receptionnaire']);
        });
    }
};
