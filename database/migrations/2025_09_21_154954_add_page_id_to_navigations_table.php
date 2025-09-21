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
        Schema::table('navigations', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id')->nullable()->after('url');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('set null');
            $table->index('page_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navigations', function (Blueprint $table) {
            $table->dropForeign(['page_id']);
            $table->dropIndex(['page_id']);
            $table->dropColumn('page_id');
        });
    }
};
