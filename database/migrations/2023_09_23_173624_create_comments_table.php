<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('by')->nullable();
            $table->text('text')->nullable();
            $table->dateTime('time')->nullable();
            $table->string('type')->nullable();

            // Foreign keys
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedBigInteger('story_id')->nullable();

            // Indexes
            $table->index('id');

            // Foreign key constraints
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('set null');
            $table->foreign('story_id')->references('id')->on('stories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['story_id']);
            $table->dropIfExists();
        });
    }
}
