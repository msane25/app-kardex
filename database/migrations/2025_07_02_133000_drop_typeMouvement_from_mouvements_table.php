<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mouvements', function (Blueprint $table) {
            if (Schema::hasColumn('mouvements', 'typeMouvement')) {
                $table->dropColumn('typeMouvement');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mouvements', function (Blueprint $table) {
            if (!Schema::hasColumn('mouvements', 'typeMouvement')) {
                $table->string('typeMouvement')->nullable();
            }
        });
    }
}; 