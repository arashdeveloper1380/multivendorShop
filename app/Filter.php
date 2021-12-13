<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filter extends Model
{
    use SoftDeletes;
    protected $table = "filters";

    protected $fillable = [
        'category_id','title',
        'parent_id','position',
        'item_id'
    ];

    public static function addFilter($ّFilter, $childFilter, $category_id,$itemValue)
    {
        $parentPosition = 0;
        self::where(['category_id'=>$category_id,'parent_id'=>0])->update(['position'=>0]);
        foreach ($ّFilter as $key => $value) {
            if(!empty($value))
            {
                $parentPosition++;
                $item_id = array_key_exists($key,$itemValue) ? $itemValue[$key] : 0;
                if($key<0 && !empty($value))
                {
                    $id = self::insertGetId([
                        'title'=>$value,
                        'category_id'=>$category_id,
                        'parent_id'=>0,
                        'position'=>$parentPosition,
                        'item_id'=>$item_id
                    ]);

                    self::add_child_filters($key,$childFilter,$id,$category_id);
                }
                else{
                    self::where('id',$key)->update([
                        'title'=>$value,
                        'position'=>$parentPosition,
                        'item_id'=>$item_id
                    ]);
                    self::add_child_filters($key,$childFilter,$key,$category_id);
                }
            }
        }
    }

    public static function add_child_filters($key,$childFilter,$filter_id,$category_id)
    {
        if(array_key_exists($key,$childFilter))
        {
            $child_position = 0;
            self::where(['parent_id'=>$filter_id])->update(['position'=>0]);
            foreach ($childFilter[$key] as $key2 => $value2) {
                if(!empty($value2))
                {
                    $child_position++;
                    if($key2<0)
                    {
                        self::insert([
                            'title'=>$value2,
                            'parent_id'=>$filter_id,
                            'category_id'=>$category_id,
                            'position'=>$child_position,
                        ]);
                    }
                    else{
                        self::where('id',$key2)->update([
                            'title'=>$value2,
                            'position'=>$child_position,
                        ]);
                    }
                }
            }
        }
    }

    public function getChild(){
        return $this->hasMany(Filter::class, 'parent_id', 'id')->orderBy('position','ASC');
    }

    public static function getProductFilter($Product)
    {
        define('product_id',$Product->id);
        $Category = Category::find($Product->category_id);
        $cat_id[0] = $Product->category_id;
        if($Category)
        {
            $cat_id[1] = $Category->parent_id;
        }
        $filters = self::with(['getChild','getValue'])->where(['parent_id'=>0])
        ->whereIn('category_id',$cat_id)
        ->orderBy('position','ASC')->get();

        return $filters;
    }

    public function getValue(){
        return $this->hasMany(ProductFilter::class, 'filter_id', 'id')
        ->where('product_id',product_id);
    }
}
