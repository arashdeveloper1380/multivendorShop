<?php

namespace App\Http\Controllers\Backend;

use App\Brand;
use App\Http\Controllers\Controller;;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Brand = Brand::getData($request->all());
        $countModel = Brand::count();
        $trashBrand = Brand::onlyTrashed()->count();

        return view('admin.brand.index',compact('Brand','trashBrand','countModel','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required',
            'brand_ename' => 'required',
            'brand_icon' => 'image'
          ],[
            'brand_name.required' => 'نام برند شما باید درج شود',
            'brand_ename.required' => 'نام لاتین برند شما باید درج شود',
            'brand_icon.image' => 'فایل باید از نوع تصویر باشد'
          ]);
          if($validator->fails()){
            return redirect()->route('brand.create')->withErrors($validator)->withInput();
          }else{
              $Brand = new Brand($request->all());

              $Brand_icon = upload_file($request,'brand_icon','brand');
              $Brand->brand_icon = $Brand_icon;

              $Brand->saveOrFail();

              return redirect()->route('brand.index')->with('success','با موفقیت ثبت شد');
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Brand = Brand::findOrFail($id);

        return view('admin.brand.edit',compact('Brand'));
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
        $Brand = Brand::findOrFail($id);
        $Brand_icon = upload_file($request,'brand_icon','brand');
        if($Brand_icon !=null){
            $Brand->img = $Brand_icon;
        }
        $Brand->update($request->all());

        return redirect()->route('brand.index')->with('warning','با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Brand = Brand::withTrashed()->findOrFail($id);
        if($Brand->deleted_at == null){
            $Brand->delete();
            return redirect()->route('brand.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
        }else{
            $Brand->forceDelete();
            return redirect()->route('brand.index')->with('danger','با موفقیت حذف شد');
        }
    }

    public function restore($id){
        $Brand = Brand::withTrashed()->where('id',$id)->findOrFail($id);
        $Brand->restore();

        return redirect()->route('brand.index')->with('restore','با موفقیت بازیابی شد');
    }

    public function remove_item(Request $request){
        $ids = $request->get('brand_id',array());
        foreach($ids as $key=>$value){
            $row = Brand::withTrashed()->where('id',$value)->firstOrFail();
            if($row->deleted_at == null){
                $row->delete();
            }else{
                $row->forceDelete();
            }
        }
        return redirect()->route('brand.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
    }

    public function restore_item (Request $request){
        $ids = $request->get('brand_id',array());
        foreach ($ids as $key => $value) {
            $Brand = Brand::withTrashed()->where('id',$value)->firstOrFail();
            $Brand->restore();
        }
        return redirect()->route('brand.index')->with('restore','ها با موفقیت بازیابی شدند');
    }
}
