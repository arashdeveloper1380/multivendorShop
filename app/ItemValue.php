<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemValue extends Model
{
    protected $table = "item_value";

    protected $fillable = [
        'product_id',
        'item_id',
        'item_value'
    ];
}
