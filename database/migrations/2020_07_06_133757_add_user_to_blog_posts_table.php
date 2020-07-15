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
            // Koristimo nullable kad vec imamo postojane korisnike(citati dokumentaciju)
            // $table->unsignedBigInteger('user_id')->nullable();

            // error kod testiranja
            if(env('DB_CONNECTION') === 'sqlite') {
                // $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('user_id')->default(0);
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
            // prvo strani kljuc tek onda columna
            // ako zelimo izbrisati strani kljuc, stavimo u array jer po defaltu naziv je user_id_index(citati dokumentaciju => https://laravel.com/docs/7.x/migrations#dropping-indexes)
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
