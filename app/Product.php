<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'id','title','ename',
        'product_url','price',
        'show','view','keywords',
        'description','special','category_id',
        'brand_id','image_url','tozihat','order_number','status'
    ];

    public static function productStatus(){
        $array = array();

        $array[-3] = 'رد شده';
        $array[-2] = 'در انتظار بررسی';
        $array[-1] = 'توقف تولید';
        $array[0]  = 'نا موجود';
        $array[1]  = 'منتشر شده';

        return $array;
    }

    // Show Data & Search Data
    public static function getData($request){
        $string = '?';
        $Product = self::latest();
        if(inTrashed($request)){
            $Product=$Product->onlyTrashed();
            $string = create_paginate_url($string,'trashed=true');
        }

        if(array_key_exists('string',$request) && !empty($request['string'])){
            $Product = $Product->where('title','like','%'.$request['string'].'%');
            $Product = $Product->orWhere('ename','like','%'.$request['string'].'%');
            $string = create_paginate_url($string,'string='.$request['string']);
        }

        $Product = $Product->orderBy('created_at','DESC')->paginate(5);
        $Product->withPath($string);
        return $Product;
    }

    protected static function boot()
    {
        parent::boot();
        self::deleting(function($product){
            if($product->isForceDeleting()){
                remove_file($product->image_url,'products');
                DB::table('product_color')->where('product_id',$product->id)->delete();
                DB::table('item_value')->where('product_id',$product->id)->delete();
            }
        });
    }
}
