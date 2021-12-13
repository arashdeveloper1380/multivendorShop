@php use App\lib\Jdf; $jdf = new Jdf(); @endphp
<div class="breadcrumb">
    <ul class="list-inline">
        <li class="pull-right pr-2">
            <a href="{{ url('admin') }}">
                <span class="fa fa-home vertical-middle pr-1"></span>
                <span>پیشخوان</span>
                @if (isset($data))
                    <span class="fa fa-angle-left vertical-middle"></span>
                @endif
            </a>
        </li>

        @if (isset($data) && is_array($data))
            @foreach ($data as $key=>$value)
                <li class="pull-right pr-2">
                    <a href="{{ url($value['url']) }}">
                        <span>{{ $value['title'] }}</span>
                        @if ($key!=(sizeof($data)-1) || isset($_GET['trashed']))
                            <span class="fa fa-angle-left vertical-middle"></span>
                        @endif
                    </a>
                </li>
            @endforeach
        @endif

        @if (isset($_GET['trashed']))
            <li class="pull-right pr-2">
                <a>
                    <span>سطل زباله</span>
                </a>
            </li>
        @endif

        <li class="pull-left date_li">
            <span class="fa fa-calendar"></span>
            <span> امروز : </span>
            <span>{{ $jdf->jdate('l') }}</span>
            <span>{{ $jdf->jdate('j') }}</span>
            <span>{{ $jdf->jdate('F') }}</span>
            <span>{{ $jdf->jdate('Y') }}</span>
        </li>

    </ul>
</div>
