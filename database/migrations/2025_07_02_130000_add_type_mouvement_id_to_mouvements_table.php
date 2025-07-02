<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mouvements', function (Blueprint $table) {
            if (!Schema::hasColumn('mouvements', 'type_mouvement_id')) {
                $table->unsignedBigInteger('type_mouvement_id')->nullable()->after('date_mouvement');
                $table->foreign('type_mouvement_id')->references('id_type_mouvement')->on('type_mouvements')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mouvements', function (Blueprint $table) {
            if (Schema::hasColumn('mouvements', 'type_mouvement_id')) {
                $table->dropForeign(['type_mouvement_id']);
                $table->dropColumn('type_mouvement_id');
            }
        });
    }
}; 