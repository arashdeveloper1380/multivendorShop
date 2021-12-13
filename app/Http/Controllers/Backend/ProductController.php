<?php

namespace App\Http\Controllers\Backend;

use App\Brand;
use App\Category;
use App\Color;
use App\Filter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Item;
use App\Product;
use App\ProductFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Product = Product::getData($request->all());
        $countModel = Product::count();
        $trashProduct = Product::onlyTrashed()->count();
        return view('admin.product.index',compact('Product','countModel','trashProduct','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Color = Color::all();
        $Brand = Brand::pluck('brand_name','id')->toArray();
        $Category = Category::where('parent_id',0)->get();

        return view('admin.product.create',compact('Color','Brand','Category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $productColor = $request->get('product_color',array());
        $product = new Product($request->all());
        $product_url =get_url($request->get('title'));
        $product->product_url = $product_url;
        $product->view = 0;
        $imageUrl = upload_file($request,'image_url','products');
        $product->image_url = $imageUrl;
        $product->saveOrFail();

        foreach ($productColor as $key => $value) {
            DB::table('product_color')->insert([
                'product_id'=>$product->id,
                'color_id'=>$value,
                'cat_id'=> $product->category_id
            ]);
        }
        return redirect()->route('product.index')->with('success','با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $Color = Color::all();
        $Brand = Brand::pluck('brand_name','id')->toArray();
        $Category = Category::where('parent_id',0)->get();
        $productColor = DB::table('product_color')->where('product_id',$product->id)->pluck('id','color_id')->toArray();
        return view('admin.product.edit',compact('product','Color','Brand','Category','productColor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $productColor = $request->get('product_color',array());
        $product_url =get_url($request->get('title'));
        $product->product_url = $product_url;
        $imageUrl = upload_file($request,'image_url','products');
        if(!empty($imageUrl)){
            remove_file($product->image_url,'products');
            $product->image_url = $imageUrl;
        }

        if(!empty($product->keywords)){
            $product->keywords = $request->get('keywords');
        }

        $product->update($request->all());

        DB::table('product_color')->where('product_id',$product->id)->delete();

        foreach ($productColor as $key => $value) {
            DB::table('product_color')->insert([
                'product_id'=>$product->id,
                'color_id'=>$value,
                'cat_id'=>$product->category_id
            ]);
        }

        return redirect()->route('product.index')->with('warning','با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        if($product->deleted_at == null){
            $product->delete();
            return redirect()->route('product.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
        }else{
            $product->forceDelete();
            return redirect()->route('product.index')->with('danger','با موفقیت حذف شد');
        }
    }

    public function restore($id)
    {
        $row = Product::withTrashed()->findOrFail($id);
        $row->restore();

        return redirect()->route('product.index')->with('restore','با موفقیت بازیابی شد');
    }

    public function restore_item(Request $request)
    {
        $ids = $request->get('product_id', array());
        foreach ($ids as $key => $value) {
            $row = Product::withTrashed()->where('id',$value)->firstOrFail();
            $row->restore();
        }

        return redirect()->route('product.index')->with('restore','ها با موفقیت بازیابی شدند');
    }

    public function remove_item(Request $request)
    {
        $ids = $request->get('product_id', array());
        foreach ($ids as $key => $value) {
            $row = Product::withTrashed()->where('id',$value)->firstOrFail();
            if($row->deleted_at == null){
                $row->delete();
            }else{
                $row->forceDelete();
            }
        }

        return redirect()->route('product.index','trashed=true')->with('danger','ها با موفقیت حذف شدند');
    }

    public function items ($id)
    {
        $Product = Product::where('id',$id)->select(['id','title','category_id'])->firstOrFail();
        $data = Item::getProductItemWithFilter($Product);
        $productItems = $data['Items'];
        $filters = $data['Filters'];
        $product_filters = ProductFilter::where('product_id',$Product->id)
        ->pluck('filter_id','filter_value')->toArray();

        return view('admin.product.item',compact('Product','productItems','filters','product_filters'));
    }

    public function add_items ($id, Request $request)
    {
        $Product = Product::where('id',$id)->select(['id','title','category_id'])->firstOrFail();
        $item_value = $request->get('item_value');
        $filter_value = $request->get('filter_value');
        DB::table('item_value')->where(['product_id'=>$id])->delete();
        foreach ($item_value as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if(!empty($value2)){
                    DB::table('item_value')->insert([
                        'product_id'=>$id,
                        'item_id'=>$key,
                        'item_value'=>$value2
                    ]);
                }
            }
            Item::addFilter($key,$filter_value,$id);
        }
        return redirect()->back()->with('success','با موفقیت ثبت شد');
    }
	
	public function filters($id)
    {
        $Product = Product::where('id',$id)->select(['id','title','category_id'])->firstOrFail();
		$productFilter = Filter::getProductFilter($Product);

        return view('admin.product.filter',compact('Product','productFilter'));
    }

    public function add_filters(Request $request, $id)
    {
        $Product = Product::where('id',$id)->select(['id','title','category_id'])->firstOrFail();
        $Filter = $request->get('filter');
        DB::table('filter_product')->where('product_id',$id)->delete();
        if(is_array($Filter)){
            foreach ($Filter as $key => $value) {
                if(is_array($value)){
                    foreach ($value as $key2 => $value2) {
                        DB::table('filter_product')->insert([
                            'product_id'=>$id,
                            'filter_id'=>$key,
                            'filter_value'=>$value2
                        ]);
                    }
                }
            }
        }
        return redirect()->back()->with('success','با موفقیت ثبت شد');
    }
}
