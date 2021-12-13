<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class productWarranty extends Model
{
    use SoftDeletes;

    protected $table = "product_warranties";

    protected $fillable = [
        'product_id','warranty_id',
        'color_id','price1','price2',
        'sendTime','seller_id','productNumber',
        'productNumberCart'
    ];

    public function get_color(){
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function get_warranty(){
        return $this->belongsTo(Warranty::class, 'warranty_id', 'id');
    }

    public function get_product(){
        return $this->hasOne(Product::class, 'id', 'product_id')
        ->select(['id','title','image_url']);
    }

    public static function getData($request){
        $string = '?';
        $productWarranty = self::with(['getColor','getWarranty'])->latest();
        if(inTrashed($request)){
            $productWarranty=$productWarranty->onlyTrashed();
            $string = create_paginate_url($string,'trashed=true');
        }

        // if(array_key_exists('string',$request) && !empty($request['string'])){
        //     $productWarranty = $productWarranty->where('warranty_id','like','%'.$request['string'].'%');
        //     $productWarranty = $productWarranty->orWhere('price2','like','%'.$request['string'].'%');
        //     $string = create_paginate_url($string,'string='.$request['string']);
        // }

        $productWarranty = $productWarranty->orderBy('created_at','DESC')->paginate(5);
        $productWarranty->withPath($string);
        return $productWarranty;
    }

    protected static function boot()
    {
        parent::boot();
        static::restored(function($Warranty){
            addMinProductPrice($Warranty);
            $product = Product::select(['id','price','status'])->where('id',$Warranty->product_id)->withTrashed()->first();
            updateProductPrice($product);
        });
        static::deleted(function($Warranty){
            checkHasProductWarranty($Warranty);
            $product = Product::select(['id','price','status'])->where('id',$Warranty->product_id)->withTrashed()->first();
            updateProductPrice($product);
        });
    }
}
