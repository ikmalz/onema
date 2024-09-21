<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // migration: create_likes_table
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('likes_count')->default(0);
            $table->integer('dislikes_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('likes_count');
            $table->dropColumn('dislikes_count');
        });
    }
};
