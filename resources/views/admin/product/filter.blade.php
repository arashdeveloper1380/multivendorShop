@extends('layouts.admin_master')

@section('content')

@include('admin.includes.breadcrumb',['data'=>[
    ['title'=>'مدریت محصولات','url'=>'admin/product'],
    ['title'=>'ثبت فیلتر های محصول','url'=>'admin/product/'.$Product->id.'/filter'],
]])

<div class="panel">
    <div class="header"> افزودن فیلتر <span style="color: cornflowerblue">{{ $Product->title }}</span></div>
    <div class="panel_content" id="product_filter_box">
        @include('admin.includes.alert',['model'=>'فیلتر های محصول',Session::get('success')])

        @if (sizeof($productFilter)>0)

            <form action="{{ route('product.add_filters',$Product->id) }}" method="post">
                @csrf

                @foreach ($productFilter as $key => $value)
                    <div class="item_groups" style="margin-bottom: 20px">
                        <p class="title">{{ $value->title }}</p>
                        @foreach ($value->getChild as $key2 => $value2)
                            <div class="form-group">
                                <input @if(is_selected_filter($value->getValue,$value2->id)) checked @endif class="vertical-middle" type="checkbox" name="filter[{{ $value->id }}][]" value="{{ $value2->id }}" id="">
                                <label for="">{{ $value2->title }}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <input type="submit" class="btn btn-success" value="ثبت فیلتر ({{ $Product->title }})">
            </form>

        @endif
    </div>
</div>
@endsection