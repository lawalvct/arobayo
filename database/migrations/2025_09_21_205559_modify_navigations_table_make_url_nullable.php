<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('navigations', function (Blueprint $table) {
            // Make URL column nullable since navigation can link to pages instead of custom URLs
            $table->string('url')->nullable()->change();

            // Add page_id column if it doesn't exist
            if (!Schema::hasColumn('navigations', 'page_id')) {
                $table->unsignedBigInteger('page_id')->nullable()->after('url');
                $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navigations', function (Blueprint $table) {
            // Revert URL column to not nullable (but first update any null values)
            DB::table('navigations')->whereNull('url')->update(['url' => '/']);
            $table->string('url')->nullable(false)->change();

            // Drop page_id column if it exists
            if (Schema::hasColumn('navigations', 'page_id')) {
                $table->dropForeign(['page_id']);
                $table->dropColumn('page_id');
            }
        });
    }
};
