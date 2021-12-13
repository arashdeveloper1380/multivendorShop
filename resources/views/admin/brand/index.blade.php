@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت برند ها','url'=>'admin/brand']]])
<div class="panel">
    <div class="header">
        @if (isset($_GET['trashed']) && $_GET['trashed'] == 'true')
            سطل زباله برند ها
            @else
           لیست برند ها
        @endif
    </div>
    <div class="panel_content">

        {{-- Manage Section --}}
        @include('admin.includes.item',['trash'=>$trashBrand,'route'=>'brand','title'=>'برند'])

        {{-- Show Alert --}}
        @include('admin.includes.alert',['model'=>'برند',Session::get('success')])

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
                        <th>#</th>
                        <th>ردیف</th>
                        <th>نام برند</th>
                        <th>نام لاتین برند</th>
                        <th>توضیحات برند</th>
                        <th>تصویر برند</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Brand as $value)
                        @php $i++ @endphp
                        <tr>
                            <td class="vertical-middle"><input type="checkbox" name="brand_id[]" class="check_box" value="{{ $value->id }}">
                            <td class="vertical-middle">{{$i}}</td>
                            <td class="vertical-middle">{{ $value->brand_name }}</td>
                            <td class="vertical-middle">{{ $value->brand_ename }}</td>
                            <td class="vertical-middle font-italic" style="color: lightseagreen;text-align: right">
                                @if (!empty($value->brand_desc))
                                    {{ $value->brand_desc }}
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td class="vertical-middle">
                                @if (!empty($value->brand_icon))
                                <img src="{{ asset('upload/brand').'/'.$value->brand_icon }}" width="150">
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td style="width: 182px;" class="vertical-middle">

                                @if (!isset($_GET['trashed']))
                                    <a href="{{ url('admin/brand'.'/'.$value->id.'/edit') }}" class="btn btn-warning fa fa-edit" data-toggle="tooltip" data-placment="bottom" title="ویرایش دسته"></a>
                                @else
                                    <a data-toggle="tooltip" data-placment="bottom" title="بازیابی برند" class="btn btn-warning fa fa-refresh" onclick="restore_row('{{ url('admin/brand/restore'.'/'.$value->id) }}','{{ Session::token() }}','ایا بازیابی این برند مطمعن هستید؟')"></a>
                                @endif

                                @if (!$value->trashed())
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف برند" onclick="del_row('{{ url('admin/brand'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این برند مطمعن هستید؟')"></a>
                                @else
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف برند برای همیشه" onclick="del_row('{{ url('admin/brand'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این برند مطمعن هستید؟')"></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if (sizeof($Brand)==0)
                    <tr>
                        <td colspan="7" class="noneRecord">هیچ رکوردی یافت نشد</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </form>
        {{ $Brand->links() }}
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
