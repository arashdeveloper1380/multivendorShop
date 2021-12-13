@extends('front.shop')

@section('content')
    <div class="row slider">
        <div class="col-2">1</div>
        <div class="col-10">
            @if (sizeof($Slider) > 0)
                <div class="slider_box">
                    <div class="relative">
                        @foreach ($Slider as $key => $value)
                            <div class="slide_div an" id="slider_img_{{ $key }}" @if($key == 0) style="display: block;" @endif >
                                <a href="{{ url($value->url) }}" style='background: url("<?= asset('upload/sliders').'/'.$value->imageUrl ?>")'></a>
                            </div>
                        @endforeach
                    </div>
                    <div id="right-slide" class="fa fa-angle-right" onclick="previous()"></div>
                    <div id="left-slide" class="fa fa-angle-left" onclick="next()"></div>
                </div>
                <div class="slider_box_footer">
                    <div class="slider_bullet_div">
                        @for ($i = 0; $i < sizeof($Slider); $i++)
                            <span id="slider_bullet_{{ $i }}" @if($i == 0) class="active" @endif></span>
                        @endfor
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer')
    <script>
        loadSlider('<?= sizeof($Slider) ?>');
    </script>
@endsection