@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت رنگ ها','url'=>'admin/color']]])
<div class="panel">
    <div class="header">
        @if (isset($_GET['trashed']) && $_GET['trashed'] == 'true') سطل زباله رنگ ها @else لیست رنگ ها @endif
    </div>
    <div class="panel_content">

        {{-- Manage Section --}}
        @include('admin.includes.item',['trash'=>$trashColor,'route'=>'color','title'=>'رنگ'])

        {{-- Show Alert --}}
        @include('admin.includes.alert',['model'=>'رنگ',Session::get('success')])

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
                        <th>نام رنگ</th>
                        <th>کد رنگ</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Color as $value)
                        @php $i++ @endphp
                        <tr>
                            <td class="vertical-middle"><input type="checkbox" name="brand_id[]" class="check_box" value="{{ $value->id }}">
                            <td class="vertical-middle">{{$i}}</td>
                            <td class="vertical-middle">{{ $value->name }}</td>
                            <td class="vertical-middle">
                                <span style="background: {{ $value->code }};display: block;height: 50px;line-height: 54px; @if ($value->code=='#000000') color: #fff; @endif">{{ $value->code }}</span>
                            </td>
                            <td style="width: 182px;" class="vertical-middle">

                                @if (!isset($_GET['trashed']))
                                    <a href="{{ url('admin/color'.'/'.$value->id.'/edit') }}" class="btn btn-warning fa fa-edit" data-toggle="tooltip" data-placment="bottom" title="ویرایش رنگ"></a>
                                @else
                                    <a data-toggle="tooltip" data-placment="bottom" title="بازیابی برند" class="btn btn-warning fa fa-refresh" onclick="restore_row('{{ url('admin/color/restore'.'/'.$value->id) }}','{{ Session::token() }}','ایا بازیابی این رنگ مطمعن هستید؟')"></a>
                                @endif

                                @if (!$value->trashed())
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف برند" onclick="del_row('{{ url('admin/color'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این رنگ مطمعن هستید؟')"></a>
                                @else
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف برند برای همیشه" onclick="del_row('{{ url('admin/color'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این رنگ مطمعن هستید؟')"></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if (sizeof($Color)==0)
                        <tr>
                            <td colspan="5" class="noneRecord">هیچ رکوردی یافت نشد</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </form>
        {{ $Color->links() }}
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
