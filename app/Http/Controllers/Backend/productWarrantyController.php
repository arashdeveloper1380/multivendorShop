<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductWarrantyRequest;
use App\Product;
use App\ProductColor;
use App\productWarranty;
use App\Warranty;
use Illuminate\Http\Request;

class productWarrantyController extends Controller
{

    protected $product;
    protected $queryString;

    public function __construct(Request $request)
    {
        $productId = $request->get('product_id');
        $this->product = Product::findOrFail($productId);
        $this->queryString = 'product_id='.$productId;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productWarranty = productWarranty::getData($request->all());
        $countModel = productWarranty::count();
        $trashProductWarranty = productWarranty::onlyTrashed()->count();

        return view('admin.productWarranty.index',[
            'productWarranty'=>$productWarranty,
            'countModel'=>$countModel,
            'trashProductWarranty'=>$trashProductWarranty,
            'request'=>$request,
            'product'=>$this->product
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Warranty = Warranty::orderBy('created_at','DESC')->pluck('name','id')->toArray();
        $Color = ProductColor::with('getColor')->where('product_id',$this->product->id)->get();

        return view('admin.productWarranty.create',[
            'Warranty'=>$Warranty,
            'Color'=>$Color,
            'product'=>$this->product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductWarrantyRequest $request)
    {
        $check = productWarranty::where([
            'seller_id'=>0,
            'warranty_id'=>$request->get('warranty_id'),
            'product_id'=>$request->get('product_id'),
            'color_id'=>$request->get('color_id'),
        ])->first();

        if(!$check){
            $ProductWarranty = new productWarranty($request->all());
            $ProductWarranty->saveOrFail();

            addMinProductPrice($ProductWarranty);
            updateProductPrice($this->product);

            return redirect()->route('productWarranty.index','product_id='.$this->product->id)->with('success','با موفقیت ثبت شد');
        }else{
            return redirect()->route('productWarranty.create','product_id='.$this->product->id)->with('warning','با مشخصات انتخابی قبلا ثبت شده');
        }

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

        $product_warranty = productWarranty::findOrFail($id);

        $Warranty = Warranty::orderBy('created_at','DESC')->pluck('name','id')->toArray();
        $Color = ProductColor::with('getColor')->where('product_id',$this->product->id)->get();

        return view('admin.productWarranty.edit',[
            'product_warranty'=>$product_warranty,
            'Warranty'=>$Warranty,
            'Color'=>$Color,
            'product'=>$this->product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function update(Request $request, $id)
    {
        $ProductWarranty = productWarranty::findOrFail($id);
        $ProductWarranty->update($request->all());

        addMinProductPrice($ProductWarranty);
        updateProductPrice($this->product);

        return redirect()->route('productWarranty.index','product_id='.$this->product->id)->with('success','با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productWarranty = productWarranty::withTrashed()->findOrFail($id);
        if($productWarranty->deleted_at == null){
            $productWarranty->delete();
            return redirect()->route('productWarranty.index','trashed=true&'.$this->queryString)->with('danger','با موفقیت به سطل زباله منتقل شد');
        }else{
            $productWarranty->forceDelete();
            return redirect()->route('productWarranty.index','product_id='.$this->product->id)->with('danger','با موفقیت حذف شد');
        }
    }

    public function restore($id)
    {
        $productWarranty = productWarranty::withTrashed()->findOrFail($id);
        $productWarranty->restore();

        return redirect()->route('productWarranty.index','product_id='.$this->product->id)->with('restore','با موفقیت بازیابی شد');
    }
}
