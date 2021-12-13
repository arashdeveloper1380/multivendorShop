@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت اسلایدر ها','url'=>'admin/slider'],
        ['title'=>'ویرایش اسلایدر','url'=>'admin/slider/'.$Slider->id.'/edit']
    ]])
    <div class="panel">
        <div class="header">ویرایش اسلایدر <span style="color: cornflowerblue"> {{ $Slider->title }} </span></div>
        <div class="panel_content">
            <a href="{{ route('slider.index') }}" class="btn btn-success pull-left">لیست اسلایدر ها</a>

            <form action="{{ route('slider.update',$Slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="title">عنوان اسلایدر</label>
                    <input type="text" name="title" value="{{ $Slider->title }}" class="form-control" placeholder="عنوان اسلایدر را وارد کنید...">
                    <span class="star_input">*
                    @error('title')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="title">لینک اسلایدر</label>
                    <input type="text" name="url" value="{{ $Slider->url }}" class="form-control" placeholder="عنوان اسلایدر را وارد کنید...">
                    <span class="star_input">*
                    @error('url')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                @if (!empty($Slider->imageUrl))
                        <img src="{{ asset('upload/sliders').'/'.$Slider->imageUrl }}">
                        <p class="btn btn-warning" onclick="del_img('<?= $Slider->id ?>','<?= url('admin/slider/del_img') ?>','<?= Session::token() ?>')">حذف تصویر</p>
                @endif
                <div class="form-group">
                    <input type="file" style="display: none" name="imageUrl" id="img" onchange="loadFile(event)">
                    <input type="button" onclick="select_file()" id="output" class="btn btn-primary" value="انتخاب اسلایدر">
                    <span class="star_input">*
                    @error('imageUrl')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div><br>
                <div class="form-group">
                    <input type="file" style="display: none" name="mobile_image_url" id="img" onchange="loadFile(event)">
                    <input type="button" onclick="select_file()" id="output" class="btn btn-primary" value="انتخاب اسلایدر برای موبایل">
                </div><br>
                <div class="form-group">
                    <input type="submit" value="ویرایش اسلایدر" class="btn btn-warning">
                </div>
            </form>
        </div>
@endsection
