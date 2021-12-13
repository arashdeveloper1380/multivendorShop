@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت گارانتی ها','url'=>'admin/warranty'],
        ['title'=>'ویرایش گارانتی','url'=>'admin/warranty/'.$Warranty->id.'/edit']
    ]])
    <div class="panel">
        <div class="header"> ویرایش گارانتی <span class="pr-3" style="color: cornflowerblue"> {{ $Warranty->name }}</span></div>
        <div class="panel_content">
            <a href="{{ route('warranty.index') }}" class="btn btn-success pull-left">لیست گارانتی ها</a>

            <form action="{{ route('warranty.update',$Warranty->id) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="name">نام گارانتی</label>
                    <input type="text" name="name" value="{{ $Warranty->name }}" class="form-control" placeholder="نام گارانتی را وارد کنید...">
                    <span class="star_input">*
                    @error('name')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" value="ویرایش گارانتی" class="btn btn-warning">
                </div>
            </form>

        </div>
@endsection
