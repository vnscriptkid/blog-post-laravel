<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserToBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            if (env('DB_CONNECTION') === 'sqlite_testing') {
                $table->unsignedBigInteger('user_id')->nullable();
            } else {
                $table->unsignedBigInteger('user_id');
            }
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // blog_posts_user_id_foreign
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
