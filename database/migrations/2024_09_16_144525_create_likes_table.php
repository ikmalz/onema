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
        Schema::table('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('trailer_id')->after('id'); // Sesuaikan posisi sesuai kebutuhan
            $table->foreign('trailer_id')->references('id')->on('_trailer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['trailer_id']);
            $table->dropColumn('trailer_id');
        });
    }
};
