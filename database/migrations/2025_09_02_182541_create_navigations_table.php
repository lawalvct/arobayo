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
        Schema::create('navigations', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url')->nullable(); // Make URL nullable since navigation can link to pages
            $table->unsignedBigInteger('page_id')->nullable(); // Add page_id column
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('target')->default('_self'); // _self, _blank
            $table->string('icon')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('navigations')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->index(['parent_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigations');
    }
};
