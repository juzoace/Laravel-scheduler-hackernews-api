<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->timestamps(0); // Removed 'created_at' and 'updated_at' columns
            $table->integer('karma')->default(0);
            $table->text('about')->nullable();
            $table->string('username')->unique(); // Added 'username' column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
