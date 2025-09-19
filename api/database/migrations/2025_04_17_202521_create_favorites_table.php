<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
      Schema::create('favorites', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('restrict');
        $table->integer('movie_id');
        $table->string('movie_title');
        $table->json('genre_ids');
        $table->timestamps();
        
        $table->unique(['user_id', 'movie_id']);
      });
    }

    public function down()
    {
        Schema::dropIfExists('favorites');
    }
}
