@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت گارانتی ها','url'=>'admin/warranty']]])
<div class="panel">
    <div class="header">
        @if (isset($_GET['trashed']) && $_GET['trashed'] == 'true') سطل زباله گارانتی ها @else لیست گارانتی ها @endif
    </div>
    <div class="panel_content">

        {{-- Manage Section --}}
        @include('admin.includes.item',['trash'=>$trashWarranty,'route'=>'warranty','title'=>'گارانتی'])

        {{-- Show Alert --}}
        @include('admin.includes.alert',['model'=>'گارانتی',Session::get('success')])

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
                        <th>نام گارانتی</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Warranty as $value)
                        @php $i++ @endphp
                        <tr>
                            <td class="vertical-middle"><input type="checkbox" name="warranty_id[]" class="check_box" value="{{ $value->id }}">
                            <td class="vertical-middle">{{$i}}</td>
                            <td class="vertical-middle">{{ $value->name }}</td>
                            <td style="width: 182px;" class="vertical-middle">

                                @if (!isset($_GET['trashed']))
                                    <a href="{{ url('admin/warranty'.'/'.$value->id.'/edit') }}" class="btn btn-warning fa fa-edit" data-toggle="tooltip" data-placment="bottom" title="ویرایش گارانتی"></a>
                                @else
                                    <a data-toggle="tooltip" data-placment="bottom" title="بازیابی گارانتی" class="btn btn-warning fa fa-refresh" onclick="restore_row('{{ url('admin/warranty/restore'.'/'.$value->id) }}','{{ Session::token() }}','ایا بازیابی این گارانتی مطمعن هستید؟')"></a>
                                @endif

                                @if (!$value->trashed())
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف گارانتی" onclick="del_row('{{ url('admin/warranty'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این گارانتی مطمعن هستید؟')"></a>
                                @else
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف گارانتی برای همیشه" onclick="del_row('{{ url('admin/warranty'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این گارانتی مطمعن هستید؟')"></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if (sizeof($Warranty)==0)
                        <tr>
                            <td colspan="4" class="noneRecord">هیچ رکوردی یافت نشد</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </form>
        {{ $Warranty->links() }}
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
