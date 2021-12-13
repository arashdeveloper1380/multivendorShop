@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت تنوع قیمت ها','url'=>'admin/productWarranty']]])
<div class="panel">
    <div class="header">
        @if (isset($_GET['trashed']) && $_GET['trashed'] == 'true') سطل زباله تنوع قیمت ها @else مدریت تنوع قیمت - <span style="color: cornflowerblue"> {{ $product->title }} </span> @endif
    </div>
    <div class="panel_content">

        {{-- Manage Section --}}

        <div class="btn-group pull-left" style="z-index: 699;">
            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               مدریت تنوع قیمت
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ url('admin/productWarranty/create?product_id='.$product->id) }}">
                    <span class="fa fa-pencil"></span>
                    افزودن تنوع جدید
                </a>
                <a class="dropdown-item" href="#"></a>
                @if (isset($_GET['trashed']))
                    <a class="dropdown-item" href="{{ url('admin/productWarranty?product_id='.$product->id)}}">
                    <span class="fa fa-trash"></span>
                    لیست تنوع قیمت <span style="color: crimson;font-weight: bold">({{ $countModel }})</span>
                @else
                    <a class="dropdown-item" href="{{ url('admin/productWarranty?trashed=true&product_id='.$product->id) }}">
                    <span class="fa fa-trash"></span>
                    سطل زباله <span style="color: crimson;font-weight: bold">({{ $trashProductWarranty }})</span>
                @endif
                </a>
            </div>
        </div>


        {{-- Show Alert --}}
        @include('admin.includes.alert',['model'=>'تنوع قیمت',Session::get('success')])

        @php $i=(isset($_GET['page'])) ? (($_GET['page']-1)*5): 0; @endphp

        <form action="" method="GET" class="search_form">
            @if (isset($_GET['trashed']) && $_GET['trashed']==true)
                <input type="hidden" name="trashed" value="true">
            @endif
            <input type="text" name="string" class="form-control" value="{{ $request->get('string','') }}" placeholder="کلمه مورد نظر را جستوجو کنید...">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
        </form>

        <form method="post" id="data_form">
            @csrf
            <table class="table table-bordered table-striped table-active">
                <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>نام گارانتی</th>
                        <th>رنگ محصول</th>
                        <th>فروشنده</th>
                        <th>قیمت فروش</th>
                        <th>قیمت برای فروش</th>
                        <th>تعداد موجودی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productWarranty as $value)
                        @php $i++ @endphp
                        <tr>
                            <td class="vertical-middle">{{$i}}</td>
                            <td class="vertical-middle">{{$value->getWarranty->name}}</td>
                            <td class="vertical-middle">
                                <span style="background: {{ $value->getColor->code }};display: block;height: 50px;line-height: 54px; @if ($value->name="مشکی") color: #ffffff; @endif">{{ $value->getColor->name }}</span>
                            </td>
                            <td class="vertical-middle">@if ($value->seller_id == 0) دیجی کالا @else {{ $value->seller_id }} @endif</td>
                            <td class="vertical-middle" style="width: 200px;"><span class="alert alert-secondary">{{number_format($value->price1)}} تومان</span></td>
                            <td class="vertical-middle" style="width: 200px;"><span class="alert alert-primary">{{number_format($value->price2)}} تومان</span></td>
                            <td class="vertical-middle">{{$value->productNumber}}</td>
                            <td style="width: 150px;" class="vertical-middle">

                                @if (!isset($_GET['trashed']))
                                    <a href="{{ url('admin/productWarranty/'.$value->id.'/edit?product_id='.$product->id) }}" class="btn btn-warning fa fa-edit" data-toggle="tooltip" data-placment="bottom" title="ویرایش تنوع قیمت"></a>
                                @else
                                    <a data-toggle="tooltip" data-placment="bottom" title="بازیابی تنوع قیمت" class="btn btn-warning fa fa-refresh" onclick="restore_row('{{ url('admin/productWarranty/restore'.'/'.$value->id.'?product_id='.$product->id) }}','{{ Session::token() }}','ایا بازیابی این تنوع قیمت مطمعن هستید؟')"></a>
                                @endif

                                @if (!$value->trashed())
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف تنوع قیمت" onclick="del_row('{{ url('admin/productWarranty/'.$value->id.'?product_id='.$product->id) }}','{{ Session::token() }}','آیا حذف این تنوع قیمت مطمعن هستید؟')"></a>
                                @else
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف تنوع قیمت برای همیشه" onclick="del_row('{{ url('admin/productWarranty/'.$value->id.'?product_id='.$product->id) }}','{{ Session::token() }}','آیا حذف این تنوع قیمت برای همیشه مطمعن هستید؟')"></a>
                                @endif

                            </td>
                        </tr>
                    @endforeach

                    @if (sizeof($productWarranty)==0)
                        <tr>
                            <td colspan="8" class="noneRecord">هیچ رکوردی یافت نشد</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </form>
        {{ $productWarranty->links() }}
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
        $("#sidebarToggle").click();
    </script>
@endsection
