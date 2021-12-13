@extends('layouts.admin_master')

@section('content')
    @include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت دسته ها','url'=>'admin/category']]])
    <div class="panel">
        <div class="header">
            @if (isset($_GET['trashed']))
            سطل زباله دسته ها
            @else
            لیست دسته ها
            @endif
        </div>
        <div class="panel_content">

            {{-- Manage Section --}}
            @include('admin.includes.item',['trash'=>$trashCategory,'route'=>'category','title'=>'دسته'])

            {{-- Show Alert --}}
            @include('admin.includes.alert',['model'=>'دسته',Session::get('success')])

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
                            <th>نام دسته</th>
                            <th>دسته والد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Category as $value)
                            @php $i++ @endphp
                            <tr>
                                <td><input type="checkbox" name="category_id[]" class="check_box" value="{{ $value->id }}">
                                <td>{{$i}}</td>
                                <td>{{ $value->name }}</td>
                                <td style="position: relative" class="alert">
                                    @if (!empty($value->parent_id))
                                        <span class="alert alert-success">{{ $value->getParent->name}}</span>
                                    @else
                                    <span class="alert alert-danger">ندارد</span>
                                    @endif
                                </td>
                                <td style="width: 182px;">

                                    @if (!isset($_GET['trashed']))
                                        <a href="{{ url('admin/category'.'/'.$value->id.'/edit') }}" class="btn btn-warning fa fa-edit" data-toggle="tooltip" data-placment="bottom" title="ویرایش دسته"></a>
                                    @else
                                        <a data-toggle="tooltip" data-placment="bottom" title="بازیابی دسته" class="btn btn-warning fa fa-refresh" onclick="restore_row('{{ url('admin/category/restore'.'/'.$value->id) }}','{{ Session::token() }}','ایا بازیابی این دسته مطمعن هستید؟')"></a>
                                    @endif

                                    @if (!$value->trashed())
                                        <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف دسته" onclick="del_row('{{ url('admin/category'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این دسته مطمعن هستید؟')"></a>
                                    @else
                                        <a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف دسته برای همیشه" onclick="del_row('{{ url('admin/category'.'/'.$value->id) }}','{{ Session::token() }}','آیا حذف این دسته مطمعن هستید؟')"></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        @if (sizeof($Category)==0)
                        <tr>
                            <td colspan="5" class="noneRecord">هیچ رکوردی یافت نشد</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </form>
            {{ $Category->links() }}
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
