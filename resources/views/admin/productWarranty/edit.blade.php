@extends('layouts.admin_master')

@section('content')
    @include('admin.includes.breadcrumb',['data'=>[
        ['title'=>'مدریت تنوع قیمت ها','url'=>'admin/productWarranty?product_id='.$product->id],
        ['title'=>'ویرایش تنوع قیمت','url'=>'admin/productWarranty/edit?product_id='.$product->id]
    ]])
    <div class="panel">
        <div class="header"> ویرایش تنوع قیمت <span style="color: cornflowerblue"> {{ $product_warranty->title }} </span></div>

        <div class="panel_content">

            @include('admin.includes.alert',['model'=>'تنوع قیمت',Session::get('success')])

            <a href="{{ url('admin/productWarranty?product_id='.$product->id) }}" class="btn btn-success pull-left">لیست تنوع ها</a>
            <form action="{{ route('productWarranty.update',$product_warranty->id.'?product_id='.$product->id) }}" method="post">
                @csrf
                @method("PUT")
                <div class="form-group">
                    <label for="warranty_id">انتخاب گارانتی</label>
                    <select name="warranty_id" class="selectpicker" data-live-search="true">
                        @foreach ($Warranty as $key=>$value)
                            <option value="{{ $key }}" @if ($key ==$product_warranty->product_id) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <br>

                <div class="form-group relative">
                    <label for="color_id">انتخاب رنگ</label>
                    <select name="color_id" class="selectpicker" data-live-search="true">
                        @foreach ($Color as $value)
                            <option value="{{ $value->getColor->id }}" @if ($value->getColor->id == $product_warranty->color_id) selected @endif data-content="<div style='background-color:{{ $value->getColor->code }}; @if ($value == 'سفید') color:#000 @endif ' class='color_option'>{{ $value->getColor->name }}</div>"></option>
                        @endforeach
                    </select>
                </div>
                <br>

                <div class="form-group">
                    <label for="price1">هزینه محصول</label>
                    <input type="text" value="{{ $product_warranty->price1 }}" name="price1" class="form-control text-left price_input" placeholder="هزینه محصول را وارد کنید...">
                    <span class="star_input">*</span>
                    @error('price1')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <br>

                <div class="form-group">
                    <label for="price2">هزینه محصول فروش</label>
                    <input type="text" value="{{ $product_warranty->price2 }}" name="price2" class="form-control text-left price_input" placeholder="هزینه محصول را وارد کنید...">
                    <span class="star_input">*</span>
                    @error('price2')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <br>
                <div class="form-group">
                    <label for="productNumber">تعداد موجدی محصول</label>
                    <input type="text" value="{{ $product_warranty->productNumber }}" name="productNumber" class="form-control text-left price_input" placeholder="تعداد موجدی محصول را وارد کنید...">
                </div>
                <br>

                <div class="form-group">
                    <label for="productNumberCart">تعداد سفارش سبد خرید</label>
                    <input type="text" value="{{ $product_warranty->productNumberCart }}" name="productNumberCart" class="form-control text-left price_input" placeholder="تعداد سفارش سبد خرید را وارد کنید...">
                </div>
                <br>

                <div class="form-group">
                    <label for="sendTime">زمان آماده سازی</label>
                    <input type="text" value="{{ $product_warranty->sendTime }}" name="sendTime" class="form-control text-left price_input" placeholder="زمان ارسال را وارد کنید...">
                    <span class="star_input">*</span>
                    @error('sendTime')
                        <span class="required">{{ $message }}</span>
                    @enderror
                </div>
                <br>

                <div class="form-group">
                    <input type="submit" value="ویرایش تنوع قیمت " class="btn btn-success">
                </div>
            </form>
        </div>

    </div>
@endsection

@section('footer')
<script src="{{ asset('js/bootstrap-select.js') }}"></script>
<script src="{{ asset('js/defaults-fa_IR.js') }}"></script>
@endsection
