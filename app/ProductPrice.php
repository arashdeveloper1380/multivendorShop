<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $table = "product_price";

    protected $fillable = [
        'warranty_id','time',
        'year','month','dey',
        'price','product_id',
        'color_id'
    ];
}
