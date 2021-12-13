<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = "categories";

    protected $fillable = [
        'id','name','ename','parent_id',
        'url','img','search_url','status'
    ];

    public function getChild(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function getParent(){
        return $this->hasOne(Category::class, 'id', 'parent_id')->withTrashed();
    }

    public static function getData($request){
        $string = '?';
        $Category = self::with('getParent');
        if(inTrashed($request)){
            $Category=$Category->onlyTrashed();
            $string = create_paginate_url($string,'trashed=true');
        }

        if(array_key_exists('string',$request) && !empty($request['string'])){
            $Category = $Category->where('name','like','%'.$request['string'].'%');
            $Category = $Category->orWhere('ename','like','%'.$request['string'].'%');
            $string = create_paginate_url($string,'string='.$request['string']);
        }

        $Category = $Category->orderBy('created_at','DESC')->paginate(5);
        $Category->withPath($string);
        return $Category;
    }

    public static function boot(){
        parent::boot();
        static::deleting(function($Category){
            cache()->forget('catList');
            foreach($Category->getChild()->withTrashed()->get() as $cat){
                if($Category->isForceDeleting()){
                    if(!empty($Category->img) && file_exists('upload/category/'.$Category->img)){
                        unlink('upload/category/'.$Category->img);
                        $cat->forceDelete();
                    }

                }else{
                    $cat->delete();
                }
            }
        });
        static::restoring(function($Category){
            cache()->forget('catList');
            foreach($Category->getChild()->withTrashed()->get() as $cat){
                $cat->restore();
            }
        });
    }
}
