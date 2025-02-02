<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('like_comments', function (Blueprint $table) {
            if (Schema::hasColumn('like_comments', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('like_comments', 'comment_text')) {
                $table->dropColumn('comment_text');
            }
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('like_comments', function (Blueprint $table) {
            //
        });
    }
};
