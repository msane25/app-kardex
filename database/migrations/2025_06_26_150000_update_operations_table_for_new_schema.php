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
        Schema::table('operations', function (Blueprint $table) {
            // Remove old columns if they exist
            if (Schema::hasColumn('operations', 'type_operation')) {
                $table->dropColumn('type_operation');
            }
            if (Schema::hasColumn('operations', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('operations', 'date_operation')) {
                $table->dropColumn('date_operation');
            }
            // Add new columns
            if (!Schema::hasColumn('operations', 'libelle')) {
                $table->string('libelle')->after('id');
            }
            if (!Schema::hasColumn('operations', 'id_type_mouvement')) {
                $table->unsignedBigInteger('id_type_mouvement')->after('libelle');
                $table->foreign('id_type_mouvement')->references('id_type_mouvement')->on('type_mouvements')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operations', function (Blueprint $table) {
            if (Schema::hasColumn('operations', 'libelle')) {
                $table->dropColumn('libelle');
            }
            if (Schema::hasColumn('operations', 'id_type_mouvement')) {
                $table->dropForeign(['id_type_mouvement']);
                $table->dropColumn('id_type_mouvement');
            }
            // Optionally, you could re-add the old columns here if needed
        });
    }
};
