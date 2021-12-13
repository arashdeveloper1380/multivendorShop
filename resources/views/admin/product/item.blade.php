@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[
    ['title'=>'مدریت محصولات','url'=>'admin/product'],
    ['title'=>'ثبت مشخصات فنی محصول','url'=>'admin/product/'.$Product->id.'/item'],
]])

<div class="panel">
    <div class="header">افزودن مشخصات فنی <span style="color: cornflowerblue">{{ $Product->title }}</span></div>
    <div class="panel_content">
        @php $filter_array = getFilterArray($filters) @endphp
        @include('admin.includes.alert',['model'=>'مشخصات فنی محصول',Session::get('success')])

        @if (sizeof($productItems)>0)

            <form action="{{ route('product.add_items',$Product->id) }}" method="post">
                @csrf
                @foreach ($productItems as $key=>$value)
                    <div class="item_groups" style="margin-bottom: 20px">
                        <p class="title">{{ $value->title }}</p>
                        @foreach ($value->getChild as $key2=>$value2)
                            <div class="form-group">
                                <label>{{ $value2->title }}</label>

                                @if (sizeof($value2->getValue)>0)
                                    <input type="text" value="{{ $value2->getValue[0]->item_value }}" name="item_value[{{ $value2->id }}][]" class="form-control item_value" style="width: 650px">
                                @else
                                    <input type="text" name="item_value[{{ $value2->id }}][]" class="form-control item_value" style="width: 650px">
                                @endif

                                @if (array_key_exists($value2->id,$filter_array))
                                    <input type="hidden" value="{{ getFilterItemValue($filters[$filter_array[$value2->id]]->id,$product_filters) }}" class="filter_value" name="filter_value[{{ $value2->id }}][{{ $filters[$filter_array[$value2->id]]->id }}]">
                                    <div class="btn btn-dark show_filter_box">انتخاب</div>
                                    <div class="item_filter_box">
                                        <ul>
                                            @foreach ($filters[$filter_array[$value2->id]]['getChild'] as $k => $v)
                                                <li>
                                                    <input @if(array_key_exists($v->id,$product_filters)) checked @endif type="checkbox" value="{{ $v->id }}">
                                                    <span>{{ $v->title }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <span class="fa fa-plus-circle" onclick="add_item_value_input({{ $value2->id }})"></span>
                                @endif
                                <div class="input_item_box" id="input_item_box_{{ $value2->id }}">

                                    @if (sizeof($value2->getValue)>1)
                                        @foreach ($value2->getValue as $item_key=>$item_value)
                                            @if ($item_key>0)
                                                <div class ="form-group">
                                                    <label></label>
                                                    <input name="item_value[{{ $value2->id }}][]" value="{{ $item_value->item_value }}" type="text" class="form-control" style="width: 650px">
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <input type="submit" class="btn btn-success" value="ثبت مشخصات فنی ({{ $Product->title }})">
            </form>

        @endif


    </div>
</div>
@endsection
