<?php

namespace App\Http\Controllers\Backend;

use App\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $Color = Color::getData($request->all());
        $countModel = Color::count();
        $trashColor = Color::onlyTrashed()->count();

        return view('admin.color.index',compact('request','Color','countModel','trashColor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.color.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,['name'=>'required','code'=>'required'],[],['name'=>'نام رنگ','code'=>'کد رنگ']);

        $Color = new Color($request->all());
        $Color->saveOrFail();

        return redirect()->route('color.index')->with('success','با موفقیت ثبت شد');
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
        $Color = Color::findOrFail($id);

        return view('admin.color.edit',compact('Color'));
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
        $Color = Color::findOrFail($id);
        $Color->update($request->all());

        return redirect()->route('color.index')->with('warning','با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Color = Color::withTrashed()->findOrFail($id);
        if($Color->deleted_at == null){
            $Color->delete();
            return redirect()->route('color.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
        }else{
            $Color->forceDelete();
            return redirect()->route('color.index')->with('danger','با موفقیت حذف شد');
        }
    }

    public function restore($id)
    {
        $Color = Color::withTrashed()->findOrFail($id);
        $Color->restore();

        return redirect()->route('color.index')->with('restore','با موفقیت بازیابی شد');
    }

    public function restore_item(Request $request)
    {
        $ids = $request->get('brand_id');
        foreach ($ids as $value) {
            $row = Color::withTrashed()->where('id',$value)->firstOrFail();
            $row->restore();

            return redirect()->route('color.index')->with('restore','با موفقیت بازیابی شد');
        }
    }

    public function remove_item(Request $request)
    {
        $ids = $request->get('brand_id');
        foreach ($ids as $value) {
            $row = Color::withTrashed()->where('id',$value)->firstOrFail();
            if($row->deleted_at == null){
                $row->delete();
            }else{
                $row->forceDelete();
            }
            return redirect()->route('color.index','trashed=true')->with('danger','ها با موفقیت حذف شدند');
        }
    }
}
