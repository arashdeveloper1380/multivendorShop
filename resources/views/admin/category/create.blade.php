@extends('layouts.admin_master')

@section('content')
    @include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت دسته ها','url'=>'admin/category'],
        ['title'=>'افزودن دسته','url'=>'admin/category/create']
    ]])
    <div class="panel">
        <div class="header">افزودن دسته جدید</div>

        <div class="panel_content">
            <a href="{{ route('category.index') }}" class="btn btn-success pull-left">لیست دسته ها</a>
            <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">نام دسته</label>
                    <input type="text" name="name" class="form-control" placeholder="نام دسته را وارد کنید...">
                    <span class="star_input">*</span>
                    @error('name')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="ename">نام لاتین دسته</label>
                    <input type="text" name="ename" class="form-control" placeholder="نام لاتین دسته را وارد کنید...">
                    <span class="star_input">*</span>
                    @error('ename')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="ename">لینک دسته</label>
                    <input type="text" name="search_url" class="form-control" placeholder="لینک دسته را وارد کنید...">
                    @error('search_url')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="parent_id">انتخاب دسته</label>
                    <select name="parent_id" class="selectpicker" data-live-search="true">
                        <option value="0">دسته والد</option>
                        @foreach ($parentCategory as $level_one)
                            <option value="{{ $level_one->id }}">{{ $level_one->name }}</option>
                            @foreach ($level_one->getChild as $level_two)
                                <option value="{{ $level_two->id }}">╝=={{ $level_two->name }}</option>
                                @foreach ($level_two->getChild as $level_tree)
                                    <option value="{{ $level_tree->id }}">╝====={{ $level_tree->name }}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label for="img">تصویر دسته</label>
                    <input type="file" style="display: none" name="img" id="img" onchange="loadFile(event)">
                    <img src="{{ asset('files/images/pic_1.jpg') }}" id="output" onclick="select_file()" width="150">
                    @error('image')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="status">وضعیت نمایش</label>
                    <input type="checkbox" name="status">
                </div>
                <br>
                <div class="form-group">
                    <input type="submit" value="ثبت دسته" class="btn btn-success">
                </div>
            </form>
        </div>

    </div>
@endsection

@section('footer')
<script src="{{ asset('js/bootstrap-select.js') }}"></script>
<script src="{{ asset('js/defaults-fa_IR.js') }}"></script>
@endsection
