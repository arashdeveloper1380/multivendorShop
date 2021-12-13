<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('ename')->nullable();  // English Title Product
            $table->string('product_url');
            $table->integer('price')->nullable();
            $table->integer('discount_price')->nullable();
            $table->smallInteger('show')->default(1); // 1 : Show Product ||  0 : Not Show Product
            $table->integer('view');
            $table->text('keywords')->nullable(); // Product Tag
            $table->text('description')->nullable();
            $table->smallInteger('special')->default(0); // 1 : Special Product ||  0 : Not Special Product
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->string('image_url')->nullable();
            $table->text('tozihat')->nullable();
            $table->integer('order_number')->default(0); // Count sell Product
            $table->softDeletes(); // Recycle Bin Product
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
        Schema::dropIfExists('products');
    }
}
