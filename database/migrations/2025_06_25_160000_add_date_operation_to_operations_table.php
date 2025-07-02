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
        if (!Schema::hasColumn('operations', 'date_operation')) {
            Schema::table('operations', function (Blueprint $table) {
                $table->date('date_operation')->nullable()->after('type_operation');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('operations', 'date_operation')) {
            Schema::table('operations', function (Blueprint $table) {
                $table->dropColumn('date_operation');
            });
        }
    }
};
