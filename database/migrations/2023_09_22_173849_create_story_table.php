<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->boolean('deleted')->default(false);
            $table->string('type')->nullable();
            $table->string('by')->nullable();
            $table->dateTime('time')->nullable();
            $table->text('text')->nullable();
            $table->boolean('dead')->default(false);
            $table->unsignedBigInteger('poll')->nullable();
            $table->string('url')->nullable();
            $table->integer('score')->default(0);
            $table->string('title')->nullable();
            $table->text('parts')->nullable();
            $table->integer('descendants')->default(0);
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('authors'); 
            $table->string('category')->nullable(); 
        });
    }

    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropForeign(['author_id']); 
        });
        
        Schema::dropIfExists('stories');
    }
};
