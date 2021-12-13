<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>پنل مدریت</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('header')
</head>
<body>
    <div class="container-fluid">
        <div class="page_sidebar">
        <span class="fa fa-bars" id="sidebarToggle"></span>
            <ul id="sidebar_menu">
                <li>
                    <a>
                        <span class="fa fa-shopping-cart vertical-middle"></span>
                        <span class="sidebar_menu_text">محصولات</span>
                        <span class="fa fa-angle-left pull-left pl-3 font-weight-bolder"></span>
                    </a>
                    <div class="child_menu">
                        <a href="{{ route('product.index') }}">مدریت محصولات</a>
                        <a href="{{ route('product.create') }}">افزودن محصول</a>
                        <a href="{{ route('category.index') }}">مدریت دسته ها</a>
                        <a href="{{ route('warranty.index') }}">مدریت گارانتی</a>
                    </div>
                </li>
                <li>
                    <a>
                        <span class="fa fa-amazon vertical-middle"></span>
                        <span class="sidebar_menu_text">برند</span>
                        <span class="fa fa-angle-left pull-left pl-3 font-weight-bolder"></span>
                    </a>
                    <div class="child_menu">
                        <a href="{{ route('brand.index') }}">مدریت برند</a>
                        <a href="{{ route('brand.create') }}">افزودن برند</a>
                    </div>
                </li>
                <li>
                    <a>
                        <span class="fa fa-pencil vertical-middle"></span>
                        <span class="sidebar_menu_text">رنگ</span>
                        <span class="fa fa-angle-left pull-left pl-3 font-weight-bolder"></span>
                    </a>
                    <div class="child_menu">
                        <a href="{{ route('color.index') }}">مدریت رنگ</a>
                        <a href="{{ route('color.create') }}">افزودن رنگ</a>
                    </div>
                </li>
                <li>
                    <a>
                        <span class="fa fa-sliders vertical-middle"></span>
                        <span class="sidebar_menu_text">اسلایدر</span>
                        <span class="fa fa-angle-left pull-left pl-3 font-weight-bolder"></span>
                    </a>
                    <div class="child_menu">
                        <a href="{{ route('slider.index') }}">مدریت اسلایدر</a>
                        <a href="{{ route('slider.create') }}">افزودن اسلایدر</a>
                    </div>
                </li>

                <li>
                    <a>
                        <span class="fa fa-gift vertical-middle"></span>
                        <span class="sidebar_menu_text">پیشنهاد</span>
                        <span class="fa fa-angle-left pull-left pl-3 font-weight-bolder"></span>
                    </a>
                    <div class="child_menu">
                        <a href="{{ route('incredible-offers') }}">مدریت پیشنهادات</a>
                    </div>
                </li>

            </ul>
        </div>
        <div class="page_content">
            <div class="content_box" id="app">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="loading_box">
        <div class="loading_div">
            <div class="loading"></div>
            <span>درحال ارسال اطلاعات</span>
        </div>
    </div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/adminVue.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@yield('footer')
</body>
</html>
