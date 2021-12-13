<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Product;
use App\productWarranty;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    
    public function incredible_offers()
    {
        return view('admin.incredible-offers');
    }

    public function getWarranty()
    {
        $productWarranty = productWarranty::with(['get_color','get_product','get_warranty'])
        ->orderBy('id','DESC')->whereHas('get_warranty')->whereHas('get_product')
        ->paginate(1);

        return $productWarranty;
    }

}
