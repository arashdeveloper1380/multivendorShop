@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت محصولات','url'=>'admin/product'],
        ['title'=>'افزودن محصول','url'=>'admin/product/create']
    ]])

    @php use App\Product; $status = Product::productStatus(); @endphp

    <div class="panel">
        <div class="header">افزودن محصول جدید</div>
        <div class="panel_content">
            <a href="{{ route('product.index') }}" class="btn btn-success pull-left">لیست محصولات</a>

            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title" class="pull-right" style="padding: 9px 0px;">عنوان محصول</label>
                    <input type="text" name="title" class="form-control product_title" placeholder="عنوان محصول را وارد کنید...">
                    <span class="star_input">*
                    @error('title')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tozihat">توضیحات</label>
                    <textarea name="tozihat" class="ckeditor"></textarea>
                    @error('tozihat')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-7">

                        <div class="form-group">
                            <label for="ename">عنوان لاتین محصول</label>
                            <input type="text" name="ename" class="form-control text-left row_input_product" placeholder="...English Product Title">
                            @error('ename')
                                <span class="required">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group relative">
                            <label for="category_id">انتخاب دسته</label>
                            <select name="category_id" class="selectpicker row_input_product" data-live-search="true">
                                <option selected disabled>انتخاب کنید</option>
                                @foreach ($Category as $level_one)
                                    <option value="{{ $level_one->id }}" data-content="<span class='category_input'>{{ $level_one->name }}</span>"></option>
                                    @foreach ($level_one->getChild as $level_two)
                                        <option value="{{ $level_two->id }}" data-content="<span class='category_input_2'>╝=={{ $level_two->name }}</span>"></option>
                                        @foreach ($level_two->getChild as $level_tree)
                                            <option value="{{ $level_tree->id }}" data-content="<span class='category_input_3'>╝===={{ $level_tree->name }}</span>"></option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select><a href="{{ route('category.create') }}"><span class="fa fa-plus btn btn-primary pull-right add_item_product"></span></a>
                            @error('category_id')
                                <span class="required">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group relative">
                            <label for="brand_id">انتخاب برند</label>
                            <select name="brand_id" class="selectpicker row_input_product" data-live-search="true">
                                <option selected disabled>انتخاب کنید</option>
                                @foreach ($Brand as $id=>$value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select><a href="{{ route('brand.create') }}"><span class="fa fa-plus btn btn-primary pull-right add_item_product"></span></a>
                            @error('brand_id')
                                <span class="required">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group relative">
                            <label for="brand_id">انتخاب رنگ</label>
                            <select name="product_color[]" class="selectpicker row_input_product" data-live-search="true" multiple="multiple">
                                @foreach ($Color as $key=>$value)
                                    <option value="{{ $value->id }}" data-content="<div style='background-color:{{ $value->code }}; @if ($value->name = 'سفید') color:#000 @endif ' class='color_option'>{{ $value->name }}</div>"></option>
                                @endforeach
                            </select><a href="{{ route('color.create') }}"><span class="fa fa-plus btn btn-primary pull-right add_item_product"></span></a>
                            @error('product_color')
                                <span class="required">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group relative">
                            <label for="brand_id">وضعیت محصول</label>
                            <select name="status" class="selectpicker row_input_product" data-live-search="true">
                                @foreach ($status as $key=>$value)
                                    <option value="{{ $key }}" selected 1>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <div class="col-md-5">
                        <input type="file" style="display: none" name="image_url" id="img" onchange="loadFile(event)">
                        <div class="choice_pic_box" onclick="select_file()">
                            <span class="title">انتخاب تصویر محصول</span>
                            <img id="output" class="pic_tag" onchange="select_file()">
                        </div>
                    </div>

                </div>
                <p class="text-danger">برچسب ها با استفاده از (,) جدا می شوند</p>
                <div class="form-group relative">
                    <input type="text" name="tag_list" id="tag_list" class="form-control" placeholder="برچسب های محصول">
                    <div class="btn btn-success absolute" onclick="add_tag()"><span class="fa fa-plus"></span></div>
                </div>

                <div id="tag_box"></div><br><br>

                <div class="form-group">
                    <label for="description" style="width: 100%">توضیحات مختصر حداکثر (150) کاراکتر</label>
                    <textarea name="description" class="ckeditor"></textarea>
                    @error('description')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="submit" value="ثبت محصول" class="btn btn-success">
                    <input type="hidden" name="keywords" id="keywords">
                </div>

            </form>
        </div>
@endsection


@section('footer')
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('js/defaults-fa_IR.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection
