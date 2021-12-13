@extends('layouts.admin_master')

@section('content')

@include('admin.includes.breadcrumb',['data'=>[
    ['title'=>'مدریت برند ها','url'=>'admin/brand'],
    ['title'=>'ثبت مشخصات فنی محصول','url'=>'admin/product/'.$Category->id.'/item'],
]])

<div class="panel">

    <div class="header"> مدریت ویژگی های دسته <span style="color: cornflowerblue"> {{ $Category->name }} </span></div>

    <div class="panel_content">
        @include('admin.includes.alert',['model'=>'مشخصات فنی',Session::get('success')])

        <form action="{{ route('item.index',$Category->id) }}" method="post">
            @csrf

            <div class="category_items">
                @foreach ($Items as $key => $value)
                    <div class="form-group item_groups" id="item_{{ $value->id }}">
                        <input type="text" value="{{ $value->title }}" class="form-control item_input" name="item[{{ $value->id }}]" placeholder="نام گروه ویژگی">
                        <span class="fa fa-plus-circle" onclick="add_child_input({{ $value->id }})"></span>
                        <span class="item_remove_message" onclick="del_row('{{ url('admin/category/item/'.$value->id) }}','{{ Session::token() }}','آیا حذف این ویژگی مطمعن هستید')"> حذف کلی آیتم های گروه های <span style="color: teal">( {{ $value->title }} )</span></span>
                        <div class="child_item_box">
                            @php $i = 1; @endphp
                            @foreach ($value->getChild as $childItem)
                                <div class="form-group child_{{ $value->id }}">
                                    {{ $i }} -
                                    <input type="checkbox" @if($childItem->showItem == 1) checked @endif name="check_box_item[{{ $value->id }}][{{ $childItem->id }}]">
                                    <input type="text" name="child_item[{{ $value->id }}][{{ $childItem->id }}]" value="{{ $childItem->title }}" class="form-control child_input_item" placeholder="نام ویژگی">
                                    <span class="child_item_remove_message" onclick="del_row('{{ url('admin/category/item/'.$childItem->id) }}','{{ Session::token() }}','آیا حذف این ویژگی مطمعن هستید')"> حذف ویژگی <span style="color: cornflowerblue">( {{ $childItem->title }} )</span></span>
                                    @php $i++; @endphp
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="item_box"></div>
            <span class="fa fa-plus" onclick="add_item_input()"></span>
            <br><br>
            <input type="submit" class="btn btn-success" value="ثبت ویژگی دسته">

        </form>

    </div>
</div>

<div class="message_div">
    <div class="message_box">
        <p id="msg"></p>
        <a class="alert alert-success" onclick="delete_row()">بله</a>
        <a class="alert alert-danger" onclick="hide_box()">خیر</a>
    </div>
</div>

@endsection

@section('footer')
    <script>
        $(document).ready(function () {
            $('.category_items').sortable();
            $('.child_item_box').sortable();
        })
    </script>
@endsection
