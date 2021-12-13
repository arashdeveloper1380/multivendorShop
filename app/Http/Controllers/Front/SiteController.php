<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function index ()
    {
        $catList = getCatList();
        $Slider = Slider::orderby('id','DESC')->get();
        return view('front.index',[
            'catList'=>$catList,
            'Slider'=>$Slider
        ]);
    }

}