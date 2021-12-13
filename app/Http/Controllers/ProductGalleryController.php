<?php

namespace App\Http\Controllers;

use App\Product;
use App\productGallery;
use Illuminate\Http\Request;
use DB;

class ProductGalleryController extends Controller
{
    public function gallery($id)
    {
        $Product = Product::findOrFail($id);
        $productGallery = productGallery::where('product_id',$id)->orderBy('position','ASC')->get();
        return view('admin.product.gallery',compact('Product','productGallery'));
    }

    public function galleryUpload($id, Request $request)
    {
        $Product = Product::where('id',$id)->select(['id'])->firstOrFail();
        if($Product){
            $count = DB::table('product_galleries')->where('product_id',$id)->count();
            $imageUrl = upload_file($request, 'file', 'gallery');
            if($imageUrl !=null){
                $count++;
                DB::table('product_galleries')->insert([
                    'product_id'=>$id,
                    'imageUrl'=>$imageUrl,
                    'position'=>$count
                ]);
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function destroy($id)
    {
        $productGallery = productGallery::findOrFail($id);
        $productGallery->delete();

        $img=$productGallery->imageUrl;
        if(!empty($img))
        {
            if(file_exists('upload/gallery/'.$img))
            {
                unlink('upload/gallery/'.$img);
            }

        }
        return redirect()->back()->with('danger','تصویر با موفقیت حذف شد');
    }

    public function change_image($id, Request $request)
    {
        $position = 1;
        $parameters = $request->get('parameters');
        $parameters = explode(',',$parameters);
        foreach ($parameters as $value) {
            if(!empty($value)){
                DB::table('product_galleries')->where('id',$value)->update(['position'=>$position]);
                $position++;
            }
        }
        return 'ok';
    }
}
