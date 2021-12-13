<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    protected $table = "items";

    protected $fillable = [
        'category_id','title',
        'position','showItem',
        'parentId'
    ];

    public static function addItem($Items,$childItems,$checkedItem,$category_id)
    {
        $parentPosition = 0;
        self::where(['category_id'=>$category_id,'parentId'=>0])->update(['position'=>0]);
        foreach ($Items as $key => $value) {
            if(!empty($value))
            {
                $parentPosition++;
                if($key<0 && !empty($value))
                {
                    $id = self::insertGetId([
                        'title'=>$value,
                        'category_id'=>$category_id,
                        'parentId'=>0,
                        'position'=>$parentPosition
                    ]);

                    self::add_child_items($key,$childItems,$id,$checkedItem,$category_id);
                }
                else{
                    self::where('id',$key)->update([
                        'title'=>$value,
                        'position'=>$parentPosition,
                    ]);
                    self::add_child_items($key,$childItems,$key,$checkedItem,$category_id);
                }
            }
        }
    }

    public static function add_child_items($key,$childItems,$item_id,$checkedItem,$category_id)
    {
        if(array_key_exists($key,$childItems))
        {
            $child_position = 0;
            self::where(['parentId'=>$item_id])->update(['position'=>0]);
            foreach ($childItems[$key] as $key2 => $value2) {
                if(!empty($value2))
                {
                    $showItem = self::getShowItemValue($checkedItem,$key,$key2);
                    $child_position++;
                    if($key2<0)
                    {
                        self::insert([
                            'title'=>$value2,
                            'parentId'=>$item_id,
                            'category_id'=>$category_id,
                            'position'=>$child_position,
                            'showItem'=>$showItem
                        ]);
                    }
                    else{
                        self::where('id',$key2)->update([
                            'title'=>$value2,
                            'position'=>$child_position,
                            'showItem'=>$showItem
                        ]);
                    }
                }
            }
        }
    }

    public static function getShowItemValue($checkedItem,$key,$key2)
    {
        if(array_key_exists($key,$checkedItem))
        {
            if(array_key_exists($key2,$checkedItem[$key]))
            {
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function getChild()
    {
        return $this->hasMany(Item::class, 'parentId', 'id')->orderBy('position','ASC');
    }

    public static function getProductItem($Product)
    {
        define('product_id',$Product->id);
        $Category = Category::find($Product->category_id);
        $cat_id[0] = $Product->category_id;
        if($Category)
        {
            $cat_id[1] = $Category->parent_id;
        }
        $items = self::with('getChild.getValue')->where(['parentId'=>0])
        ->whereIn('category_id',$cat_id)
        ->orderBy('position','ASC')->get();

        return $items;
    }

    public function getValue()
    {
        return $this->hasMany(ItemValue::class, 'item_id', 'id')
        ->where('product_id',product_id);
    }

    public static function getCategoryItem($id)
    {
        $Category = Category::find($id);
        $cat_id[0] = $id;
        if($Category)
        {
            $cat_id[1] = $Category->parent_id;
        }
        $item = self::with('getChild')->where(['parentId'=>0])
        ->whereIn('category_id',$cat_id)
        ->orderBy('position','ASC')->get();

        return $item;
    }

    public static function getProductItemWithFilter($Product)
    {
        define('product_id',$Product->id);
        $Category = Category::find($Product->category_id);
        $cat_id[0] = $Product->category_id;
        if($Category)
        {
            $cat_id[1] = $Category->parent_id;
        }
        $Items = self::with('getChild.getValue')->where(['parentId'=>0])
        ->whereIn('category_id',$cat_id)
        ->orderBy('position','ASC')->get();

        $Filters = Filter::whereIn('category_id',$cat_id)
        ->where(['parent_id'=>0])
        ->whereNotNull('item_id')->with('getChild')->get();

        return ['Items'=>$Items,'Filters'=>$Filters];
    }

    public static function addFilter($key,$filter_value,$product_id)
    {
        if(array_key_exists($key,$filter_value))
        {
            foreach ($filter_value[$key] as $key => $value) {
                $filter_id = $key;
                DB::table('filter_product')
                    ->where([
                        'product_id'=>$product_id,
                        'filter_id'=>$filter_id
                    ])->delete();
                $e = explode('@',$value);
                foreach ($e as $key2 => $value2) {
                    if(!empty($value2)){
                        DB::table('filter_product')
                            ->insert([
                                'product_id'=>$product_id,
                                'filter_id'=>$filter_id,
                                'filter_value'=>$value2
                            ]);
                    }
                }
            }
        }
    }
}
