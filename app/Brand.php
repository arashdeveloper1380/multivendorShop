<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $table = "brands";

    protected $fillable = [
        'id','brand_name','brand_ename',
        'brand_icon','brand_desc'
    ];

    public static function getData($request){
        $string = '?';
        $Brand = self::latest();
        if(inTrashed($request)){
            $Brand=$Brand->onlyTrashed();
            $string = create_paginate_url($string,'trashed=true');
        }

        if(array_key_exists('string',$request) && !empty($request['string'])){
            $Brand = $Brand->where('brand_name','like','%'.$request['string'].'%');
            $Brand = $Brand->orWhere('brand_ename','like','%'.$request['string'].'%');
            $string = create_paginate_url($string,'string='.$request['string']);
        }

        $Brand = $Brand->orderBy('created_at','DESC')->paginate(5);
        $Brand->withPath($string);
        return $Brand;
    }

    public static function boot(){
        parent::boot();
        static::deleting(function($Brand){
            if($Brand->isForceDeleting()){
                if(!empty($Brand->brand_icon) && file_exists('upload/brand/'.$Brand->brand_icon)){
                    unlink('upload/brand/'.$Brand->brand_icon);
                }
            }
        });
    }
}
