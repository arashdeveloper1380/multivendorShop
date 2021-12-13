<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Warranty;
use Validator;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Warranty = Warranty::getData($request->all());
        $countModel = Warranty::count();
        $trashWarranty = Warranty::onlyTrashed()->count();

        return view('admin.warranty.index',compact('Warranty','countModel','trashWarranty','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.warranty.create');
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
            'name' => 'required',
          ],[
            'name.required' => 'نام گارانتی شما باید درج شود'
          ]);
          if($validator->fails()){
            return redirect()->route('warranty.create')->withErrors($validator)->withInput();
          }else{
              $Warranty = new Warranty($request->all());
              $Warranty->saveOrFail();

              return redirect()->route('warranty.index')->with('success','با موفقیت ثبت شد');
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
        $Warranty = Warranty::findOrFail($id);

        return view('admin.warranty.edit',compact('Warranty'));
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
        $Warranty = Warranty::findOrFail($id);
        $Warranty->update($request->all());

        return redirect()->route('warranty.index')->with('warning','با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Warranty = Warranty::withTrashed()->findOrFail($id);
        if($Warranty->deleted_at == null){
            $Warranty->delete();
            return redirect()->route('warranty.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
        }else{
            $Warranty->forceDelete();
            return redirect()->route('warranty.index')->with('danger','با موفقیت حذف شد');
        }
    }

    public function restore($id)
    {
        $Warranty = Warranty::withTrashed()->findOrFail($id);
        $Warranty->restore();

        return redirect()->route('warranty.index')->with('restore','با موفقیت بازیابی شد');
    }

    public function remove_item(Request $request)
    {
        $ids = $request->get('warranty_id');

        foreach ($ids as $key => $value) {
            $row = Warranty::withTrashed()->where('id',$value)->firstOrFail();
            if($row->deleted_at == null){
                $row->delete();
                return redirect()->route('warranty.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
            }else{
                $row->forceDelete();
                return redirect()->route('warranty.index')->with('danger','با موفقیت حذف شد');
            }
        }
    }

    public function restore_item(Request $request)
    {
        $ids = $request->get('warranty_id');

        foreach ($ids as $key => $value) {
            $row = Warranty::withTrashed()->where('id',$value)->firstOrFail();
            $row->restore();
        }

        return redirect()->route('warranty.index')->with('restore','با موفقیت بازیابی شد');
    }
}
