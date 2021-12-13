<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductWarrantiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_warranties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('warranty_id');
            $table->integer('color_id')->default(0);
            $table->integer('price1');
            $table->integer('price2');  // For Discount
            $table->integer('sendTime');
            $table->integer('seller_id')->default(0);
            $table->integer('productNumber')->nullable();  // Count Product For Sell
            $table->integer('productNumberCart')->nullable();          // Count For Basket Shop
            $table->softDeletes();
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
        Schema::dropIfExists('product_warranties');
    }
}
