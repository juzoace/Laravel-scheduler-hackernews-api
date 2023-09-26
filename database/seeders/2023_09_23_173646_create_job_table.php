<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hackernews_jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // 'id' as primary key
            $table->string('by')->nullable();             // Assuming 'by' is a string and nullable
            $table->integer('score')->default(0);         // Assuming 'score' is an integer with a default value of 0
            $table->text('text')->nullable();             // Assuming 'text' is a text field
            $table->dateTime('time')->nullable();         // Assuming 'time' is a datetime field
            $table->string('title')->nullable();          // Assuming 'title' is a string and nullable
            $table->string('type')->nullable();           // Assuming 'type' is a string and nullable
            $table->string('url')->nullable();            // Assuming 'url' is a string and nullable
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hackernews_jobs');
    }
};
