<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_mouvements', function (Blueprint $table) {
            $table->id('id_type_mouvement');
            $table->string('mouvement'); // Entrée, Sortie, Retour
            $table->timestamps();
        });

        // Insertion des valeurs par défaut
        DB::table('type_mouvements')->insert([
            ['mouvement' => 'Entrée', 'created_at' => now(), 'updated_at' => now()],
            ['mouvement' => 'Sortie', 'created_at' => now(), 'updated_at' => now()],
            ['mouvement' => 'Retour', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_mouvements');
    }
};
