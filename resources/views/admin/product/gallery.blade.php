@extends('layouts.admin_master')

@section('content')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
@endsection

@include('admin.includes.breadcrumb',['data'=>[['title'=>'گالری تصاویر','url'=>'admin/product/gallery/'.$Product->id]]])
<div class="panel">

    <div class="header">گالری تصاویر <span style="color: cornflowerblue"> {{ $Product->title }} </span></div>

    <div class="panel_content">
        @include('admin.includes.alert',['model'=>'گالری تصاویر',Session::get('success')])

        <form action="{{ url('admin/product/gallery/Upload/'.$Product->id) }}" method="post" class="dropzone">
            @csrf
            <input type="file" name="file[]" style="display: none" multiple>
        </form>
    </div>
    <table class="table table-bordered table-striped table-active" id="gallery_table">
        <thead>
            <tr>
                <th>ردیف</th>
                <th>تصویر</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($productGallery as $gallery)
            <tr id="{{ $gallery->id }}">
                <td class="vertical-middle">{{ $i++ }}</td>
                <td class="vertical-middle"><img src="{{ asset('upload/gallery').'/'.$gallery->imageUrl }}" width="150"></td>
                <td class="vertical-middle"><a class="btn btn-danger fa fa-trash" data-toggle="tooltip" data-placment="bottom" title="حذف عکس" onclick="del_row('{{ url('admin/product/gallery'.'/'.$gallery->id) }}','{{ Session::token() }}','آیا حذف این عکس مطمعن هستید؟')"></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script>
        Dropzone.options.uploadFile={

        acceptedFiles:".png,.jpg,.gif,.jpeg",
        addRemoveLinks:true,
        init:function() {
            this.options.dictRemoveFile='حذف',
            this.options.dictInvalidFileType='امکان آپلود این فایل وجود ندارد',
            this.on('success',function(file,response) {
                if(response==1)
                {
                    file.previewElement.classList.add('dz-success');
                }
                else
                {
                    file.previewElement.classList.add('dz-error');
                    $(file.previewElement).find('.dz-error-message').text('خطا در آپلود فایل');
                }
            });
        }
    };

    const $sortable = $("#gallery_table > tbody");
    $sortable.sortable({
        stop:function(event,ui){
            $(".loading_box").show();
            const parameters = $sortable.sortable("toArray");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{ url('admin/product/change_images_status/'.$Product->id) }}',
                type:'POST',
                data:'parameters='+parameters,
                success:function(data)
                {
                    $(".loading_box").hide();
                }
            })
        }
    });
    </script>
@endsection
