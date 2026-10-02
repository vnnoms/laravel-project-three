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
    Schema::table('activities', function (Blueprint $table) {
        $table->foreignId('category_id')
            ->after('id')
            ->constrained()
            ->restrictOnDelete();

        $table->string('code', 30)->unique()->after('category_id');

        $table->dropColumn('category');
    });
}

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');

            $table->dropUnique(['code']);
            $table->dropColumn('code');

            $table->string('category', 50)->default('')->after('activity_date');
        });
    }
};
