<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUsernameCommenttextFromDislikeComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dislike_comments', function (Blueprint $table) {
            if (Schema::hasColumn('dislike_comments', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('dislike_comments', 'comment_text')) {
                $table->dropColumn('comment_text');
            }
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dislike_comments', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->text('comment_text')->nullable();
        });
    }
}
