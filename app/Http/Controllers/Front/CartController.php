<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // addTocart
    public function addTocartQV(Request $request){
        // 3 way to retrive data from database
        // $product = DB::table('products')->where('id',$request->id)->first();
        // $product = Product::where('id',$request->id)->first();
        $product = Product::find($request->id);
        
        Cart::add([
            'id'=>$product->id, //$request->id
            'name'=> $product->name,
            'qty'=> $request->qty,
            'price'=> $request->price,
            'weight'=> '1',
            'option'=> [
                'size'=>$request->size,
                'color'=>$request->color,
                'thumbnail'=>$product->thumbnail,
            ],
        ]);

        return response()->json('Added!');
    }
}
