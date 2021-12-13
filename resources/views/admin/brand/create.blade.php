@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت برند ها','url'=>'admin/brand'],
        ['title'=>'افزودن برند','url'=>'admin/brand/create']
    ]])
    <div class="panel">
        <div class="header">افزودن برند جدید</div>
        <div class="panel_content">
            <a href="{{ route('brand.index') }}" class="btn btn-success pull-left">لیست برند ها</a>

            <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="brand_name">نام برند</label>
                    <input type="text" name="brand_name" class="form-control" placeholder="نام برند را وارد کنید...">
                    <span class="star_input">*
                    @error('brand_name')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brand_ename">نام لاتین برند</label>
                    <input type="text" name="brand_ename" class="form-control" placeholder="نام لاتین برند را وارد کنید...">
                    <span class="star_input">*
                    @error('brand_ename')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brand_desc" class="pull-right">توضیحات برند</label>
                    <textarea name="brand_desc" class="form-control brand_desc"></textarea>
                </div>
                <div class="form-group">
                    <input type="file" style="display: none" name="brand_icon" id="img" onchange="loadFile(event)">
                    <input type="button" onclick="select_file()" id="output" class="btn btn-primary" value="انتخاب ایکون برند">
                    @error('image')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div><br>
                <div class="form-group">
                    <input type="submit" value="ثبت برند" class="btn btn-success">
                </div>
            </form>

        </div>
@endsection
