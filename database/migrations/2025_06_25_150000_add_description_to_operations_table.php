<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('operations', 'description')) {
            Schema::table('operations', function (Blueprint $table) {
                $table->text('description')->nullable()->after('type_operation');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('operations', 'description')) {
            Schema::table('operations', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};
