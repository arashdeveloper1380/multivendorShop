<div class="index-cat-list container-fluid">
    <ul>
        <li class="cat_hover">
            <div></div>
        </li>
        {{-- Level 1 --}}
        @foreach ($catList as $key => $value)
            <li class="cat_item">
            <a href="{{ url('main/'.$value->url) }}">{{ $value->name }}</a>

            @if (sizeof($value->getChild) > 0)
            <div class="li_div">
                @php $c = 0; @endphp

                @if (sizeof($value->getChild) > 0) @if ($c == 0) <ul class="list-inline sublist"> @endif @endif
               
                    @foreach ($value->getChild as $key2 => $value2)



                        @if ($value2->status == 0)
                        @if (getShowCategoryCount($value2->getChild) >= (14-$c)) @php $c = 0; @endphp </ul> <ul class="list-inline sublist"> @endif
                        <li>
                            <a href="{{ getCatUrl($value2) }}" class="child_cat">
                                <span class="fa fa-angle-left"></span>
                                <span>{{ $value2->name }}</span>
                            </a>
                            <ul>
                                {{-- Level 3 --}}
                                @foreach ($value2->getChild as $key3 => $value3)
                                    @if ($value3->status == 1)
                                        <li><a href="{{ getCatUrl($value3) }}">
                                            {{ $value3->name }}</a>
                                        </li>
                                        @php $c++ @endphp
                                    @endif
                                @endforeach{{-- Level 3 --}}
                            </ul>
                        </li>
                        @php $c++ @endphp
                        @if ($c == 13) </ul> @php $c = 0; @endphp <ul class="list-inline sublist"> @endif


                        @else
                            {{-- Level 3 --}}
                            @foreach ($value2->getChild as $key3 => $value3)
                                @if (getShowCategoryCount($value3->getChild) >= (14-$c)) @php $c = 0; @endphp </ul> <ul class="list-inline sublist"> @endif
                                @if ($value3->status == 1)
                                    <li>
                                        <a href="{{ getCatUrl($value3) }}" class="child_cat">
                                            <span class="fa fa-angle-left"></span>
                                            <span>{{ $value3->name }}</span>
                                        </a>

                                        <ul>
                                            {{-- Level 4 --}}
                                            @foreach ($value3->getChild as $key4 => $value4)
                                                @if ($value4->status == 1)
                                                    <li><a href="{{ getCatUrl($value4) }}">
                                                        {{ $value4->name }}</a>
                                                    </li>
                                                    @php $c++ @endphp
                                                @endif
                                            @endforeach{{-- Level 4 --}}
                                        </ul>

                                    </li>

                                    @php $c++ @endphp
                                    @if ($c == 13) </ul> @php $c = 0; @endphp <ul class="list-inline sublist"> @endif
                                @else

                                @endif
                                
                            @endforeach{{-- Level 3 --}}

                        @endif
                    
                    @endforeach{{-- Level 2 --}}

                    @if ($c != 0 && getShowCategoryCount($value->getChild) > 0) </ul> @endif
                    <div class="show-total-cat">
                        <a href="">
                            <span class="all">مشاهده تمام دسته های </span>
                            <span class="all">{{ $value->name }}</span>
                        </a>
                    </div>

                    @if (!empty($value->img))
                        <a href="">
                            <div class="sub-menu-pic">
                                <img src="{{ asset('upload/category').'/'.$value->img }}" alt="">
                            </div>
                        </a>
                    @endif
            </div>
            @endif
            {{-- Level 2 --}}
            

        @endforeach{{-- Level 1 --}}

        <li class="cat_item left-item"><a href="">فروش ویژه</a></li>
    </ul>
</div>