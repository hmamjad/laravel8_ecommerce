<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    public function index(){
        $category = DB::table('categories')->get();  //$category = Category::all();
        $bannerproduct = Product::where('product_slider',1)->latest()->first();  //  $bannerproduct = DB::table('products')->where('product_slider',1)->latest()->first();
        return view('frontend.index',compact('category','bannerproduct'));
    }
}
