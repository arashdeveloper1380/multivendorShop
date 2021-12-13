@extends('layouts.admin_master')

@section('content')
@include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت اسلایدر ها','url'=>'admin/slider']]])
<div class="panel">
    <div class="header">
        @if (isset($_GET['trashed']) && $_GET['trashed'] == 'true')
            سطل زباله اسلایدر ها
            @else
           لیست اسلایدر ها
        @endif
    </div>
    <div class="panel_content">

        {{-- Manage Section --}}
        @include('admin.includes.item',['trash'=>$trashSlider,'route'=>'slider','title'=>'اسلایدر'])

        {{-- Show Alert --}}
        @include('admin.includes.alert',['model'=>'اسلایدر',Session::get('success')])

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
                        <th>عنوان اسلایدر</th>
                        <th>تصویر اسلایدر</th>
                        <th>تصویر موبایل اسلایدر</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Slider as $value)
                        @php $i++ @endphp
                        <tr>
                            <td class="vertical-middle"><input type="checkbox" name="slider_id[]" class="check_box" value="{{ $value->id }}">
                            <td class="vertical-middle">{{$i}}</td>
                            <td class="vertical-middle">{{ $value->title }}</td>
                            <td class="vertical-middle">
                                @if (!empty($value->imageUrl))
                                    <img src="{{ asset('upload/sliders').'/'.$value->imageUrl }}" width="150">
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td class="vertical-middle">
                                @if (!empty($value->mobile_image_url))
                                    <img src="{{ asset('upload/sliders').'/'.$value->mobile_image_url }}" width="150">
                                @else
                                    ندارد
                                @endif
                            </td>
                            <td style="width: 182px;" class="vertical-middle">

                                @if (!isset($_GET['trashed']))
                                    <a href="{{ url('admin/slider'.'/'.$value->id.'/edit') }}" class="btn btn-warning fa fa-edit" data-toggle="tooltip" data-placment="bottom" title="ویرایش اسلایدر"></a>
                                @else
                                    <a data-toggle="tooltip" data-placment="bottom" title="بازیابی اسلایدر" class="btn btn-warning fa fa-refresh" onclick="restore_row('{{ url('admin/slider/restore'.'/'.$value->id) }}','{{ Session::token() }}','ایا بازیابی این اسلایدر مطمعن هستید؟')"></a>
                                @endif

                                @if (!$value->trashed())
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف اسلایدر" onclick="del_row('{{ url('admin/slider'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این اسلیدر مطمعن هستید؟')"></a>
                                @else
                                    <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف اسلایدر برای همیشه" onclick="del_row('{{ url('admin/slider'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این اسلایدر مطمعن هستید؟')"></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if (sizeof($Slider)==0)
                    <tr>
                        <td colspan="6" class="noneRecord">هیچ رکوردی یافت نشد</td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </form>
        {{ $Slider->links() }}
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
