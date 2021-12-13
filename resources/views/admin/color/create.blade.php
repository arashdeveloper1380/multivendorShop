@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت رنگ ها','url'=>'admin/color'],
        ['title'=>'افزودن رنگ','url'=>'admin/color/create']
    ]])
    <div class="panel">
        <div class="header">افزودن رنگ جدید</div>
        <div class="panel_content">
            <a href="{{ route('color.index') }}" class="btn btn-success pull-left">لیست رنگ ها</a>

            <form action="{{ route('color.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">نام رنگ</label>
                    <input type="text" name="name" class="form-control" placeholder="نام رنگ را وارد کنید...">
                    <span class="star_input">*
                    @error('name')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="code">کد رنگ</label>
                    <input type="text" name="code" class="form-control jscolor">
                    <span class="star_input">*
                    @error('code')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" value="ثبت رنگ" class="btn btn-success">
                </div>
            </form>
        </div>
@endsection


@section('footer')
    <script src="{{ asset('js/jscolor.min.js') }}"></script>t
@endsection
