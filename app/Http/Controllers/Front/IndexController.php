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
        // $category = DB::table('categories')->get();  //$category = Category::all();
        // $bannerproduct = Product::where('product_slider',1)->latest()->first();  //  $bannerproduct = DB::table('products')->where('product_slider',1)->latest()->first();
        // $featured = Product::where('featured',1)->orderBy('id','DESC')->limit(8)->get();  //  $bannerproduct = DB::table('products')->where('product_slider',1)->latest()->first();
        // return view('frontend.index',compact('category','bannerproduct','featured'));


        $category=DB::table('categories')->orderBy('category_name','ASC')->get();
        $brand=DB::table('brands')->where('front_page',1)->limit(24)->get();
        $bannerproduct=Product::where('status',1)->where('product_slider',1)->latest()->first();
        $featured=Product::where('status',1)->where('featured',1)->orderBy('id','DESC')->limit(16)->get();
        $todaydeal=Product::where('status',1)->where('today_deal',1)->orderBy('id','DESC')->limit(6)->get();
        $popular_product=Product::where('status',1)->orderBy('product_views','DESC')->limit(16)->get();
        $trendy_product=Product::where('status',1)->where('trendy',1)->orderBy('id','DESC')->limit(8)->get();
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        // $review=DB::table('wbreviews')->where('status',1)->orderBy('id','DESC')->limit(12)->get();
        //homepage category
        $home_category=DB::table('categories')->where('home_page',1)->orderBy('category_name','ASC')->get();


        // $campaign=DB::table('campaigns')->where('status',1)->orderBy('id','DESC')->first();

        return view('frontend.index',compact('category','bannerproduct','featured','popular_product','trendy_product','brand','random_product','todaydeal','home_category'));
    }

    // singleProduct page calling Method
    public function ProductDetails($slug){
        $product = Product::where('slug',$slug)->first(); //$product = DB::table('products')->where('slug',$slug)->first();
         Product::where('slug',$slug)->increment('product_views');
        $related_product=DB::table('products')->where('subcategory_id',$product->subcategory_id)->orderBy('id','DESC')->take(10)->get();  //take(10) == limit(10)
        $review=Review::where('product_id',$product->id)->orderBy('id','DESC')->take(6)->get();
        return view('frontend.product.product_details',compact('product','related_product','review'));
    }


     //product quick view
     public function ProductQuickView($id)
     {
         $product=Product::where('id',$id)->first();
        //  return response()->json($product);
         return view('frontend.product.quick_view',compact('product'));
        
     }

    //  category wise product
    public function categoryWiseProduct($id){
        $category = DB::table('categories')->where('id',$id)->first();
        $subcategory = DB::table('subcategories')->where('category_id',$id)->get();
        $brand = DB::table('brands')->get();
        $products = DB::table('products')->where('category_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();

        return view('frontend.product.category_products',compact('category','subcategory','brand','products','random_product'));
    }

    //  Sub-category wise product
    public function SubcategoryWiseProduct($id){
        $subcategory = DB::table('subcategories')->where('id',$id)->first();
        $childcategory = DB::table('childcategories')->where('subcategory_id',$id)->get();
        $brand = DB::table('brands')->get();
        $products = DB::table('products')->where('subcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();

        return view('frontend.product.subcategory_products',compact('subcategory','childcategory','brand','products','random_product'));
    }
    //  Child-category wise product
    public function ChildcategoryWiseProduct($id){
        $childcategory = DB::table('childcategories')->where('id',$id)->first();
        $category = DB::table('categories')->get();
        $brand = DB::table('brands')->get();
        $products = DB::table('products')->where('childcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();

        return view('frontend.product.childcategory_products',compact('childcategory','category','brand','products','random_product'));
    }
}
