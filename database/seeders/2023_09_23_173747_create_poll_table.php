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
        Schema::create('hackernews_polls', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // 'id' as primary key
            $table->string('by')->nullable();           // Assuming 'by' is a string
            $table->integer('descendants')->default(0); // Assuming 'descendants' is an integer
            $table->text('kids')->nullable();           // Assuming 'kids' is a text field, perhaps storing JSON?
            // 'parts' might be represented via the relationship so no direct column may be needed here.
            $table->integer('score')->default(0);       // Assuming 'score' is an integer
            $table->text('text')->nullable();           // Assuming 'text' is a text field
            $table->timestamp('time')->nullable();      // Assuming 'time' is a timestamp
            $table->string('title')->nullable();        // Assuming 'title' is a string
            $table->string('type')->nullable();         // Assuming 'type' is a string
            // No need for timestamps since $timestamps property is set to false in the model
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hackernews_polls');
    }
};
