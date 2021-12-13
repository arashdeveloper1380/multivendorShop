@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت رنگ ها','url'=>'admin/color'],
        ['title'=>'ویرایش رنگ','url'=>'admin/color/'.$Color->id.'/edit']
    ]])
    <div class="panel">
        <div class="header"> ویرایش رنگ ==><span style="color: cornflowerblue"> {{ $Color->name }} </span></div>
        <div class="panel_content">
            <a href="{{ route('color.index') }}" class="btn btn-success pull-left">لیست رنگ ها</a>

            <form action="{{ route('color.update',$Color->id) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="name">نام رنگ</label>
                    <input type="text" value="{{ $Color->name }}" name="name" class="form-control" placeholder="نام رنگ را وارد کنید...">
                    <span class="star_input">*
                    @error('name')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="code">کد رنگ</label>
                    <input type="text" value="{{ $Color->code }}" name="code" class="form-control jscolor">
                    <span class="star_input">*
                    @error('code')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="submit" value="ویرایش رنگ" class="btn btn-success">
                </div>
            </form>
        </div>
@endsection


@section('footer')
    <script src="{{ asset('js/jscolor.min.js') }}"></script>t
@endsection
