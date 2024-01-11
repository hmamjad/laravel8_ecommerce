<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{
    //root page
    public function index(){
        $category = DB::table('categories')->get();  //$category = Category::all();
        $bannerproduct = Product::where('product_slider',1)->latest()->first();  //  $bannerproduct = DB::table('products')->where('product_slider',1)->latest()->first();
        return view('frontend.index',compact('category','bannerproduct'));
    }

    // singleProduct page calling Method
    public function ProductDetails($slug){
        $product = Product::where('slug',$slug)->first(); //$product = DB::table('products')->where('slug',$slug)->first();
        $related_product=DB::table('products')->where('subcategory_id',$product->subcategory_id)->orderBy('id','DESC')->take(10)->get();  //take(10) == limit(10)
        $review=Review::where('product_id',$product->id)->orderBy('id','DESC')->take(6)->get();
        return view('frontend.product_details',compact('product','related_product','review'));
    }
}
