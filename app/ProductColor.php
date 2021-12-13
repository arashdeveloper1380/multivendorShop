<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = "product_color";

    protected $fillable = [
        'color_id','product_id','cat_id'
    ];

    public function getColor()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }
}
