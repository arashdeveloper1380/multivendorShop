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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('ename')->nullable();
            $table->string('url')->nullable();
            $table->string('img')->nullable();
            $table->string('search_url')->nullable();
            $table->integer('parent_id');
            $table->softDeletes(); // Recycle Bin Of Categories
            $table->smallInteger('status')->default(1); // Show Category Is :1 ||  Not Show Category Is : 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
