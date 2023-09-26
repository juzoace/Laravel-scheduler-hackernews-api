<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // Name of the category
            $table->text('description')->nullable();  // Description of the category (optional)
            $table->timestamps();  // Created at and Updated at timestamps
        });

        // Add a category_id column to the stories table
        Schema::table('stories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('descendants');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the category_id foreign key and column from the stories table
        Schema::table('stories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        // Drop the categories table
        Schema::dropIfExists('categories');
    }
}
