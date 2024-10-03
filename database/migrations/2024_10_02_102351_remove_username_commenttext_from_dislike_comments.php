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
            $table->dropColumn(['username', 'comment_text']);
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
