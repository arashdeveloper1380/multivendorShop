@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت گارانتی ها','url'=>'admin/warranty'],
        ['title'=>'افزودن گارانتی','url'=>'admin/warranty/create']
    ]])
    <div class="panel">
        <div class="header">افزودن گارانتی جدید</div>
        <div class="panel_content">
            <a href="{{ route('warranty.index') }}" class="btn btn-success pull-left">لیست گارانتی ها</a>

            <form action="{{ route('warranty.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">نام گارانتی</label>
                    <input type="text" name="name" class="form-control" placeholder="نام گارانتی را وارد کنید...">
                    <span class="star_input">*
                    @error('name')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" value="ثبت گارانتی" class="btn btn-success">
                </div>
            </form>

        </div>
@endsection
