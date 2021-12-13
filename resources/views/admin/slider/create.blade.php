@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت اسلایدر ها','url'=>'admin/slider'],
        ['title'=>'افزودن اسلایدر','url'=>'admin/slider/create']
    ]])
    <div class="panel">
        <div class="header">افزودن اسلایدر جدید</div>
        <div class="panel_content">
            <a href="{{ route('slider.index') }}" class="btn btn-success pull-left">لیست اسلایدر ها</a>

            <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">عنوان اسلایدر</label>
                    <input type="text" name="title" class="form-control" placeholder="عنوان اسلایدر را وارد کنید...">
                    <span class="star_input">*
                    @error('title')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="title">لینک اسلایدر</label>
                    <input type="text" name="url" class="form-control" placeholder="عنوان اسلایدر را وارد کنید...">
                    <span class="star_input">*
                    @error('url')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="file" style="display: none" name="image_url" id="img" onchange="loadFile(event)">
                    <input type="button" onclick="select_file()" id="output" class="btn btn-primary" value="انتخاب اسلایدر">
                    <span class="star_input">*
                    @error('image_url')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div><br>
                <div class="form-group">
                    <input type="file" style="display: none" name="mobile_image_url" id="img" onchange="loadFile(event)">
                    <input type="button" onclick="select_file()" id="output" class="btn btn-primary" value="انتخاب اسلایدر برای موبایل">
                </div><br>
                <div class="form-group">
                    <input type="submit" value="ثبت اسلایدر" class="btn btn-success">
                </div>
            </form>

        </div>
@endsection
