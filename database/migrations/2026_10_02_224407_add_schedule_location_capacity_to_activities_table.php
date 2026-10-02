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
            $table->renameColumn('activity_date', 'start_at');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable()->change();
            $table->dateTime('end_at')->nullable()->after('start_at');
            $table->string('location', 150)->nullable()->after('end_at');
            $table->unsignedSmallInteger('capacity')->nullable()->after('location');
            $table->string('status', 20)->default('draft')->change();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['end_at', 'location', 'capacity']);
            $table->string('status', 20)->default('Planned')->change();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->date('start_at')->nullable(false)->change();
            $table->renameColumn('start_at', 'activity_date');
        });
    }
};
