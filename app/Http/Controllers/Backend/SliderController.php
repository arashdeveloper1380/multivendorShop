<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Slider;
use Illuminate\Http\Request;
use Validator;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Slider = Slider::getData($request->all());
        $countModel = Slider::count();
        $trashSlider = Slider::onlyTrashed()->count();

        return view('admin.slider.index',compact('Slider','trashSlider','countModel','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Slider = new Slider($request->all());

        $image_url = upload_file($request,'image_url','sliders');
        $mobile_image_url = upload_file($request,'mobile_image_url','sliders');

        $Slider->imageUrl = $image_url;
        $Slider->mobile_image_url = $mobile_image_url;

        $Slider->saveOrFail();

        return redirect()->route('slider.index')->with('success','با موفقیت ثبت شد');
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
        $Slider = Slider::findOrFail($id);
        return view('admin.slider.edit',compact('Slider'));
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
        $Slider = Slider::findOrFail($id);
        $image_url = upload_file($request, 'imageUrl', 'sliders');
        $mobile_image_url = upload_file($request, 'mobile_image_url', 'sliders');
        $Slider->imageUrl = $image_url;
        $Slider->mobile_image_url = $mobile_image_url;
        $Slider->update([
            'title'=>$Slider->title,
            'url'=>$Slider->url,
            'imageUrl'=>$image_url,
            'mobile_image_url'=>$mobile_image_url
        ]);
        return redirect()->route('slider.index')->with('warning', 'با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Slider = Slider::withTrashed()->findOrFail($id);
        if($Slider->deleted_at == null){
            $Slider->delete();
            return redirect()->route('slider.index','trashed=true')->with('danger','با موفقیت به سطل زباله منتقل شد');
        }else{
            $Slider->forceDelete();
            remove_file($Slider->imageUrl,'sliders');
            return redirect()->route('slider.index')->with('danger','با موفقیت حذف شد');
        }
    }

    public function restore($id)
    {
        $Slider = Slider::withTrashed()->findOrFail($id);
        $Slider->restore();

        return redirect()->route('slider.index')->with('restore','با موفقیت بازیابی شد');
    }

    public function restore_item(Request $request)
    {
        $ids = $request->get('slider_id',array());
        foreach($ids as $value){
            $row = Slider::withTrashed()->where('id',$value)->firstOrFail();
            $row->restore();
        }
        return redirect()->route('slider.index')->with('restore','ها با موفقیت بازیابی شدند');
    }

    public function remove_item(Request $request)
    {
        $ids = $request->get('slider_id',array());
        foreach ($ids as $value) {
            $Slider = Slider::withTrashed()->where('id',$value)->firstOrFail();
            if($Slider->deleted_at == null){
                $Slider->delete();
            }else{
                $Slider->forceDelete();
                remove_file($Slider->imageUrl,'sliders');
                remove_file($Slider->mobile_image_url,'sliders');
            }
        }
    }

    public function del_img($id){
        $Slider = Slider::findOrFail($id);
        $imageSlider = $Slider->imageUrl;
        if(!empty($imageSlider)){
            if(file_exists('upload/sliders/'.$imageSlider)){
                $Slider->imageUrl = '';
                $Slider->update(['imageUrl',$imageSlider]);
                unlink('upload/sliders/'.$imageSlider);
            }
        }
        return redirect()->back();
    }
}
