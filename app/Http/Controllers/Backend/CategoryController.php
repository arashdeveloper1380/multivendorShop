<?php

namespace App\Http\Controllers\Backend;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
    *i
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $Category = Category::latest();
        // if(isset($_GET['trashed'])){
        //     $Category = $Category->onlyTrashed();
        // }
        // $Category = $Category->orderBy('id','DESC')->paginate(10);

        // ---------- OR


        $Category = Category::getData($request->all());
        $countModel = Category::count();
        $trashCategory = Category::onlyTrashed()->count();
        return view('admin.category.index',compact('Category','countModel','trashCategory','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategory = Category::where('parent_id', 0)->get();
        return view('admin.category.create',compact('parentCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $Category = new Category($request->all());
        $Status = $request->has('status') ? 1 : 0;
        $Category->status = $Status;
        $Category->url = get_url($request->get('ename')); // Or Str::slug($request->ename);
        $img_url = upload_file($request,'img','category');
        $Category->img = $img_url;
        $Category->saveOrFail();
        cache()->forget('catList');

        return redirect()->route('category.index')->with('success','با موفقیت ثبت شد');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Category = Category::findOrFail($id);
        $parentCategory = Category::where('parent_id', 0)->get();
        return view('admin.category.edit',compact('Category', 'parentCategory'));
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
        cache()->forget('catList');
        $data = $request->all();
        $Category = Category::findOrFail($id);
        $Status = $request->has('status') ? 1 : 0;
        $Category->status = $Status;
        $Category->url = get_url($request->get('ename')); // Or Str::slug($request->ename);
        $img_url = upload_file($request,'img','category');
        if($img_url !=null){
            $Category->img = $img_url;
        }
        $data['status'] = $Status;
        $Category->update($data);

        return redirect()->route('category.index')->with('warning','با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Category = Category::withTrashed()->findOrFail($id);
        if($Category->deleted_at == null){
            $Category->delete();
            return redirect()->route('category.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
        }else{
            $Category->forceDelete();
            return redirect()->route('category.index')->with('danger','با موفقیت حذف شد');
        }

    }

    public function remove_item(Request $request)
    {
        $ids = $request->get('category_id',array());
        foreach($ids as $key=>$value){
            $row = Category::withTrashed()->where('id',$value)->firstOrFail();
            if($row->deleted_at == null){
                $row->delete();
            }else{
                $row->forceDelete();
            }
        }
        return redirect()->route('category.index','trashed=true')->with('danger','ها با موفقیت حذف شدند');
    }

    public function restore_item(Request $request)
    {
        $ids = $request->get('category_id',array());
        foreach($ids as $key=>$value){
            $row = Category::withTrashed()->where('id',$value)->firstOrFail();
            $row->restore();
        }
        return redirect()->route('category.index')->with('restore','ها با موفقیت بازیابی شدند');
    }

    public function restore($id)
    {
        $row = Category::withTrashed()->where('id',$id)->firstOrFail();
        $row->restore();

        return redirect()->route('category.index')->with('restore','با موفقیت بازیابی شد');
    }

}
