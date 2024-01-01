<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
     // for Authenticated user
     public function __construct()
     {
         $this->middleware('auth');
     }

    //  product Create Page
    public function create(){
        $category = DB::table('categories')->get();
        $brand = DB::table('brands')->get();
        $pickup_point = DB::table('pickup_point')->get();
        $warehouse = DB::table('warehouses')->get();

        return view('admin.product.create',compact('category','brand','pickup_point','warehouse'));
    }
}
