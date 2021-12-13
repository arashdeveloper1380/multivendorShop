<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productGallery extends Model
{
    protected $table = "product_galleries";

    protected $fillable = ['product_id','imageUrl','position'];
}
