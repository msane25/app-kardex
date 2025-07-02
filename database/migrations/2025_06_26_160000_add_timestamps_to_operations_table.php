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
            if (!Schema::hasColumn('operations', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }
            if (!Schema::hasColumn('operations', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
            if (!Schema::hasColumn('operations', 'libelle')) {
                $table->string('libelle')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operations', function (Blueprint $table) {
            if (Schema::hasColumn('operations', 'created_at') && Schema::hasColumn('operations', 'updated_at')) {
                $table->dropTimestamps();
            } else {
                if (Schema::hasColumn('operations', 'created_at')) {
                    $table->dropColumn('created_at');
                }
                if (Schema::hasColumn('operations', 'updated_at')) {
                    $table->dropColumn('updated_at');
                }
            }
            if (Schema::hasColumn('operations', 'libelle')) {
                $table->dropColumn('libelle');
            }
        });
    }
};
