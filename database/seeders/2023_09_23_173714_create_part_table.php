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
        Schema::create('hackernews_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary(); // 'id' as primary key
            $table->unsignedBigInteger('poll_id');       // Foreign key for 'poll_id'
            $table->text('text')->nullable();            // Assuming 'text' is a text field
            // Add other fields specific to the 'Part' model as needed

            // Define the foreign key constraint
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
            // Adjust 'polls' in the above line if your Poll table name is different
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hackernews_parts');
    }
};
