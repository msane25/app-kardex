<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mouvements', function (Blueprint $table) {
            if (!Schema::hasColumn('mouvements', 'operation_id')) {
                $table->unsignedBigInteger('operation_id')->nullable()->after('quantite');
                $table->foreign('operation_id')->references('id_operation')->on('operations')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mouvements', function (Blueprint $table) {
            if (Schema::hasColumn('mouvements', 'operation_id')) {
                $table->dropForeign(['operation_id']);
                $table->dropColumn('operation_id');
            }
        });
    }
}; 