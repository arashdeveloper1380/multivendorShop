@extends('layouts.admin_master')

@section('content')
    @include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت محصولات','url'=>'admin/product']]])
    <div class="panel">
        <div class="header">
            @if (isset($_GET['trashed']))
            سطل زباله محصولات
            @else
            لیست محصولات
            @endif
        </div>
        <div class="panel_content">

            {{-- Manage Section --}}
            @include('admin.includes.item',['trash'=>$trashProduct,'route'=>'product','title'=>'محصول'])

            {{-- Show Alert --}}
            @include('admin.includes.alert',['model'=>'محصول',Session::get('success')])

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
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ردیف</th>
                            <th>تصویر</th>
                            <th>عنوان</th>
                            <th>فروشنده</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Product as $value)
                            @php $i++ @endphp
                            <tr>
                                <td class="vertical-middle"><input type="checkbox" name="product_id[]" class="check_box" value="{{ $value->id }}">
                                <td class="vertical-middle">{{$i}}</td>
                                <td class="vertical-middle"><img src="{{ asset('upload/products'.'/'.$value->image_url) }}" width="150"></td>
                                <td class="vertical-middle">{{ $value->title }}</td>
                                <td class="vertical-middle">دیجی کالا</td>
                                <td class="vertical-middle">
                                    @if ($value->status == 1)
                                        <span class="alert alert-success">منتشر شده</span>
                                    @elseif ($value->status == 0)
                                        <span class="alert alert-danger">نا موجود</span>
                                    @elseif ($value->status == -1)
                                        <span class="alert alert-warning">توقف تولید</span>
                                    @elseif ($value->status == -2)
                                        <span class="alert alert-primary">در انتظار بررسی</span>
                                    @elseif ($value->status == -3)
                                        <span class="alert alert-secondary">رد شده</span>
                                    @endif
                                </td>
                                <td style="width: 182px;" class="vertical-middle">

                                    @if (!isset($_GET['trashed']))
                                        <a href="{{ url('admin/product'.'/'.$value->id.'/edit') }}" class="btn btn-warning fa fa-edit" data-toggle="tooltip" data-placment="bottom" title="ویرایش محصول"></a>
                                    @else
                                        <a data-toggle="tooltip" data-placment="bottom" title="بازیابی محصول" class="btn btn-warning fa fa-refresh" onclick="restore_row('{{ url('admin/product/restore'.'/'.$value->id) }}','{{ Session::token() }}','ایا بازیابی این محصول مطمعن هستید؟')"></a>
                                    @endif

                                    @if (!$value->trashed())
                                        <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف محصول" onclick="del_row('{{ url('admin/product'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این محصول مطمعن هستید؟')"></a>
                                    @else
                                        <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف محصول برای همیشه" onclick="del_row('{{ url('admin/product'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این محصول مطمعن هستید؟')"></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if (sizeof($Product)==0)
                        <tr>
                            <td colspan="7" class="noneRecord">هیچ رکوردی یافت نشد</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </form>
            {{ $Product->links() }}
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
