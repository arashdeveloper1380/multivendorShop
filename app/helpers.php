<?php

use App\Category;
use App\lib\Jdf;
use App\ProductPrice;
use App\productWarranty;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Start Slug Category                                                     │
|--------------------------------------------------------------------------
*/
function get_url($string){
    $url = str_replace('-', ' ', $string);
    $url = str_replace('/', ' ', $url);
    $url = preg_replace('/\s+/', '-',$url);

    return $url;
}

/*
|--------------------------------------------------------------------------
| Start Upload Image                                                      │
|--------------------------------------------------------------------------
*/
function upload_file($request, $name, $directory){
    if($request->hasFile($name)){
        $file_name = time().'.'.$request->file($name)->getClientOriginalExtension();
        if($request->file($name)->move('upload/'.$directory,$file_name)){
            return $file_name;
        }else{
            return null;
        }
    }else{
        return null;
    }
}


/*
|--------------------------------------------------------------------------
| Start Recycle Bin                                                       │
|--------------------------------------------------------------------------
*/
function inTrashed($req){
    if(array_key_exists('trashed',$req) && $req['trashed']=='true'){
        return true;
    }else{
        return false;
    }
}


/*
|--------------------------------------------------------------------------
| Start Paginate Url And Serach                                           │
|--------------------------------------------------------------------------
*/
function create_paginate_url($string,$text){
    if($string == '?'){
        $string = $string.$text;
    }else{
        $string = $string.'&'.$text;
    }
    return $string;
}


/*
|--------------------------------------------------------------------------
| Start Route Crud                                                        │
|--------------------------------------------------------------------------
*/
function create_crud_route($route_param,$controller,$show=false){
    if($show){
        Route::resource($route_param, 'Backend\\'.$controller);
    }else{
        Route::resource($route_param, 'Backend\\'.$controller)->except(['show']);
    }
    Route::post($route_param.'/remove_item','Backend\\'.$controller.'@remove_item');
    Route::post($route_param.'/restore_item','Backend\\'.$controller.'@restore_item');
    Route::post($route_param.'/restore/{id}','Backend\\'.$controller.'@restore');
}


/*
|--------------------------------------------------------------------------
| Start Remove Upload Files                                               │
|--------------------------------------------------------------------------
*/
function remove_file($file_name,$directory){
    if(!empty($file_name) && file_exists('upload/'.$directory.'/'.$file_name)){
        unlink('upload/'.$directory.'/'.$file_name);
    }
}


/*
|--------------------------------------------------------------------------
| Start Variation Based On Color And Warranty                             │
|--------------------------------------------------------------------------
*/
function updateProductPrice($product){
    $warranty = productWarranty::where('product_id',$product->id)->where('productNumber','>',0)->orderBy('price2','ASC')->first();
    if($warranty){
        $product->price = $warranty->price2;
        $product->status = 1;
        $product->update();
    }else{
        $product->status = 0;
        $product->update();
    }
}

function addMinProductPrice($Warranty){
    $jdf =  new Jdf();
    $year = $jdf->tr_num($jdf->jdate('Y'));
    $month = $jdf->tr_num($jdf->jdate('n'));
    $day = $jdf->tr_num($jdf->jdate('j'));

    $has_row = DB::table('product_price')
    ->where([

        'year'=>$year,
        'month'=>$month,
        'day'=>$day,
        'color_id'=>$Warranty->color_id,
        'product_id'=>$Warranty->product_id

        ])->first();

    if($has_row){
        if($Warranty->price2<$has_row->price){
            DB::table('product_price')
            ->where([

                'year'=>$year,
                'month'=>$month,
                'day'=>$day,
                'color_id'=>$Warranty->color_id,
                'product_id'=>$Warranty->product_id

                ])->update([
                    'price'=>$Warranty->price2,
                    'warranty_id'=>$Warranty->id
                ]);
        }
    }else{
        DB::table('product_price')
        ->insert([
            'year'=>$year,
            'month'=>$month,
            'day'=>$day,
            'color_id'=>$Warranty->color_id,
            'product_id'=>$Warranty->product_id,
            'price'=>$Warranty->price2,
            'time'=>time(),
            'warranty_id'=>$Warranty->id
        ]);
    }
}


/*
|--------------------------------------------------------------------------
| Start check Has Product Warranty                                        │
|--------------------------------------------------------------------------
*/
function checkHasProductWarranty($Warranty)
{
    $jdf =  new Jdf();
    $year = $jdf->tr_num($jdf->jdate('Y'));
    $month = $jdf->tr_num($jdf->jdate('n'));
    $day = $jdf->tr_num($jdf->jdate('j'));

    $row = productWarranty::where(['product_id'=>$Warranty->product_id,'color_id'=>$Warranty->color_id])
    ->where('productNumber','>',0)
    ->orderBy('price2','ASC')
    ->first();

    $price = $row ? $row->price2 : 0;
    $warrantyId = $row ? $row->id : 0;

    $has_row = ProductPrice::where([
        'year'=>$year,
        'month'=>$month,
        'day'=>$day,
        'color_id'=>$Warranty->color_id,
        'product_id'=>$Warranty->product_id])->first();

        if($has_row){
            if($Warranty->price2<$has_row->price || $has_row
            ->price==0)
            {
                ProductPrice::where([
                    'year'=>$year,
                    'month'=>$month,
                    'day'=>$day,
                    'color_id'=>$Warranty->color_id,
                    'product_id'=>$Warranty->product_id])
                    ->update([
                        'price'=>$Warranty->price2,
                        'warranty_id'=>$Warranty->id
                    ]);
            }
        }else{
            DB::table('product_price')
                ->insert([
                    'year'=>$year,
                    'month'=>$month,
                    'day'=>$day,
                    'color_id'=>$Warranty->color_id,
                    'product_id'=>$Warranty->product_id,
                    'price'=>$price,
                    'time'=>time(),
                    'warranty_id'=>$warrantyId
            ]);
        }
}


/*
|--------------------------------------------------------------------------
| Start Selected Filter Product                                           │
|--------------------------------------------------------------------------
*/
function is_selected_filter($list,$filter_id)
{
    $request = false;
    foreach ($list as $key => $value) {
        if($value->filter_value == $filter_id){
            $request = true;
        }
    }
    return $request;
}


/*
|--------------------------------------------------------------------------
| Start Get Filter Value                                                  │
|--------------------------------------------------------------------------
*/
function getFilterArray($list)
{
    $array = array();
    foreach ($list as $key => $value) {
        $array[$value->item_id] = $key;
    }
    return $array;
}

/*
|--------------------------------------------------------------------------
| Start Get Filter Item Value                                             │
|--------------------------------------------------------------------------
*/
function getFilterItemValue($filter_id,$product_filters)
{
    $string = '';
    foreach ($product_filters as $key => $value) {
        if($value == $filter_id)
        {
            $string.='@'.$key;
        }
    }
    return $string;
}


/*
|--------------------------------------------------------------------------
| Start Get Show Category Count                                           │
|--------------------------------------------------------------------------
*/
function getShowCategoryCount($catList)
{
    $n = 0;
    foreach ($catList as $key => $value) {
        if($value->status == 1){
            $n++;
        }
    }
    return $n;
}


/*
|--------------------------------------------------------------------------
| Start Cache Category For Fast Show                                      │
|--------------------------------------------------------------------------
*/
function getCatList()
{
    $Data = cache('catList');
    if($Data){
        return $Data;
    }else{
        $Category = Category::with('getChild.getChild.getChild')->where(['parent_id'=>0])->get();
        $menutes = 30*24*60*60;
        cache()->put('catList',$Category,$menutes);
    }
    return $Category;
}


/*
|--------------------------------------------------------------------------
| Start Get Category Url                                                  │
|--------------------------------------------------------------------------
*/
function getCatUrl($cat)
{
    if(!empty($cat->search_url)){
        return url($cat->search_url);
    }else{
        return url('search/'.$cat->url);
    }
}