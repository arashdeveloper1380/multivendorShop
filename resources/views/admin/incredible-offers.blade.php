@extends('layouts.admin_master')

@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/js-persian-cal.css') }}">
@endsection

@section('content')
    @include('admin.includes.breadcrumb',['data'=>[['title'=>'مدریت پیشنهاد های شگفت انگیز','url'=>'admin/incredible-offers']]])
    <div class="panel">

        <div class="header">
            مدریت پیشنهاد های شگفت انگیز
        </div>

        <div class="panel_content">
            <incredible-offers></incredible-offers>
        </div>

    </div>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ asset('js/js-persian-cal.min.js') }}"></script>
    <script>
        
        const pcal1 = new AMIB.persianCalendar( 'pcal1' );
        const pcal2 = new AMIB.persianCalendar( 'pcal2' );
    </script>
@endsection