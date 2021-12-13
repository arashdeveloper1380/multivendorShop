@extends('layouts.admin_master')

@section('content')

@include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت فیلتر ها','url'=>'admin/category/'.$Category->id.'/filter']]])

<div class="panel">

    <div class="header"> مدریت فیلتر های دسته <span style="color: cornflowerblue"> {{ $Category->name }} </span></div>

    <div class="panel_content">
        @include('admin.includes.alert',['model'=>'فیلتر دسته',Session::get('success')])

        <form action="{{ route('filter.index',$Category->id) }}" method="post">
            @csrf
            <div class="category_filters">
                @foreach ($Filter as $key => $value)
                    <div class="form-group item_groups" id="filter_{{ $value->id }}">
                        <select name="item_id[{{ $value->id }}]" class="selectpicker" data-live-search=true>
                            <option value="0">انتخاب ویژگی (درصورت نیاز)</option>
                            @foreach ($item as $itemKey => $itemValue)
                                @foreach ($itemValue->getChild as $key2 => $value2)
                                    <option @if($value2->id == $value->item_id) selected @endif value="{{ $value2->id }}">{{ $value2->title }}</option>  
                                @endforeach
                            @endforeach
                        </select>
                        <input type="text" style="margin-right: 90px" value="{{ $value->title }}" class="form-control filter_input" name="filter[{{ $value->id }}]" placeholder="نام گروه فیلتر">
                        <span class="fa fa-plus-circle" onclick="add_filter_child_input({{ $value->id }})"></span>
                        <span class="item_remove_message" onclick="del_row('{{ url('admin/category/filter/'.$value->id) }}','{{ Session::token() }}','آیا حذف این فیلتر ها مطمعن هستید')"> حذف گروه  <span style="color: teal">( {{ $value->title }} )</span></span>
                        <div class="child_filter_box">       
                            @php $i=1; @endphp
                            @foreach ($value->getChild as $childFilter)
                                <div class="form-group child_{{ $value->id }}">
                                    {{ $i }} - <input type="text" value="{{ $childFilter->title }}" name="child_filter[{{ $value->id }}][{{ $childFilter->id }}]" class="form-control child_input_filter" placeholder="نام فیلتر">
                                    <span class="child_item_remove_message" onclick="del_row('{{ url('admin/category/filter/'.$childFilter->id) }}','{{ Session::token() }}','آیا حذف این فیلتر مطمعن هستید')"> حذف فیلتر <span style="color: cornflowerblue">( {{ $childFilter->title }} )</span></span>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="filter_box"></div>
            <span class="fa fa-plus" onclick="add_filter_input()"></span>
            <br><br>
            <input type="submit" class="btn btn-success" value="ثبت فیلتر دسته">

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
<script src="{{ asset('js/bootstrap-select.js') }}"></script>
<script src="{{ asset('js/defaults-fa_IR.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.category_filters').sortable();
            $('.child_input_filter').sortable();
        })
    </script>
@endsection
