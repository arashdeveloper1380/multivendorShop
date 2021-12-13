<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>دیجی کالا</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/site.js') }}"></script>
</head>
<body>
    <div class="app">

        {{-- Start Header Section --}}
            <div class="header">

                {{-- Start Logo --}}
                <a href="{{ route('home.index') }}">
                    <img src="{{ asset('files/images/logo.jpg') }}" class="shop_logo" alt="دیجی کالا">
                </a>{{-- End Logo --}}

                <div class="header_row">

                    {{-- Start Header Search --}}
                    <div class="input-group index_header_search">
                        <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="نام کالا, برند و یا دسته مورد نظر خود را جستوجو کنید">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i></div>
                        </div>
                    </div>{{-- End Header Search --}}

                    {{-- Start Header Action --}}
                    <div class="header_action">
                        <div class="dropdown">
                            <div class="index_auth_div" role="button" data-toggle="dropdown">
                                <span>ورود | ثبت نام</span>
                                <span class="fa fa-angle-down"></span>
                            </div>
                            <div class="dropdown-menu header-auth-box" aria-labelledby="dropdownMenuButton">

                                @if (Auth::check())
                                    @if (Auth::user()->role_id > 0 || Auth::user()->role=='admin')
                                        <a href="{{ route('dashboard') }}" class="dropdown-item admin btn btn-primary">پنل مدریت</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">ورود به دیجی کالا</a>
                                    <div class="register_link">
                                        <span>کاربر جدید هستید؟</span>
                                        <a href="{{ route('register') }}">ثبت نام</a>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                @endif

                                <a href="{{ url('profile') }}" class="dropdown-item profile">
                                    <span class="fa fa-user-o"></span>
                                    پروفایل
                                </a>
                                <a href="{{ url('profile/orders') }}" class="dropdown-item orders">
                                    <span class="fa fa-gift"></span>
                                    پیگیری سفارش
                                </a>

                                @auth

                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout">
                                            <span class="fa fa-sign-out"></span>
                                            خروج از حساب کاربری
                                        </button>
                                    </form>

                                @endauth
                                
                            </div>
                        </div>
                    </div>{{-- End Header Action --}}

                    {{-- Start Shop Cart --}}
                    <div class="header_divider"></div>
                    <div class="cart-header-box">
                        <div class="btn-cart">
                            <div id="cart-product-cart" data-counter="0">سبد خرید</div>
                        </div>
                    </div>
                    {{-- End Shop Cart --}}

                </div>

            </div>
        {{-- Start Header Section --}}

        {{-- Start Category List Section --}}
            @include('front.includes.catList',['catList'=>$catList])
        {{-- Start Category List Section --}}

        <div class="container-fluid">
            @yield('content')
        </div>

    </div>

</body>

@yield('footer')
</html>