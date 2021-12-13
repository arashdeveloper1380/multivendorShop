<div class="btn-group pull-left" style="z-index: 699;">
    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
       مدریت {{ $title }}
    </button>

    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ url('admin/'.$route.'/create') }}">
            <span class="fa fa-pencil"></span>
            افزودن {{ $title }} جدید
        </a>
        <a class="dropdown-item" href="#"></a>
        @if (isset($_GET['trashed']))
            <a class="dropdown-item" href="{{ url('admin/'.$route)}}">
            <span class="fa fa-trash"></span>
            لیست {{ $title }} <span style="color: crimson;font-weight: bold">({{ $countModel }})</span>
        @else
            <a class="dropdown-item" href="{{ url('admin/'.$route.'?trashed=true') }}">
            <span class="fa fa-trash"></span>
            سطل زباله <span style="color: crimson;font-weight: bold">({{ $trash }})</span>
        @endif
        </a>

        @if (isset($_GET['trashed']))
        <a class="dropdown-item" href="#"></a>
        <a class="dropdown-item off item_form" id="remove_item" msg="آیا حذف {{ $title }} های انتخابی مطمعن هستید؟">
            <span class="fa fa-remove"></span>
            حذف {{ $title }} ها
        </a>
        @else
        <a class="dropdown-item"></a>
        <a class="dropdown-item off item_form" id="remove_item" msg="آیا حذف {{ $title }} های انتخابی مطمعن هستید؟">
            <span class="fa fa-remove"></span>
            حذف {{ $title }} ها
        </a>
        @endif

        @if (isset($_GET['trashed']))
        <a class="dropdown-item"></a>
        <a class="dropdown-item off item_form" id="restore_item" msg="آیا بازیابی {{ $title }} های انتخابی مطمعن هستید؟">
            <span class="fa fa-refresh"></span>
            بازیابی {{ $title }} ها
        </a>
        @endif
    </div>
</div>
