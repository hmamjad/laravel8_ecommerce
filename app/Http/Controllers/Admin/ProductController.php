<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;
use Image;
use File;


class ProductController extends Controller
{
    // for Authenticated user
    public function __construct()
    {
        $this->middleware('auth');
    }

    //  product Create Page
    public function create()
    {
        $category = DB::table('categories')->get();
        $brand = DB::table('brands')->get();
        $pickup_point = DB::table('pickup_point')->get();
        $warehouse = DB::table('warehouses')->get();

        return view('admin.product.create', compact('category', 'brand', 'pickup_point', 'warehouse'));
    }

    // product store method
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:products|max:55',
            'subcategory_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'selling_price' => 'required',
            'color' => 'required',
            'description' => 'required',
        ]);

        // subcategory call for get category id
        $subcategory = DB::table('subcategories')->where('id', $request->subcategory_id)->first();

        $data = array();

        $data['category_id'] = $subcategory->category_id;
        $data['subcategory_id'] = $request->subcategory_id;
        $data['childcategory_id'] = $request->childcategory_id;
        $data['brand_id'] = $request->brand_id;
        $data['pickup_point_id'] = $request->pickup_point_id;
        $data['name'] = $request->name;
        $data['slug'] = Str::slug($request->name, '-');
        $data['code'] = $request->code;
        $data['unit'] = $request->unit;
        $data['tags'] = $request->tags;
        $data['color'] = $request->color;
        $data['size'] = $request->size;
        $data['video'] = $request->video;
        $data['purchase_price'] = $request->purchase_price;
        $data['celling_price'] = $request->celling_price;
        $data['discount_price'] = $request->discount_price;
        $data['stock_quantity'] = $request->stock_quantity;
        $data['discount_price'] = $request->discount_price;
        $data['warehouse'] = $request->warehouse;
        $data['description'] = $request->description;
        $data['featured'] = $request->featured;
        $data['today_deal'] = $request->today_deal;
        $data['status'] = $request->status;
        $data['flash_deal_id'] = $request->flash_deal_id;
        $data['cash_on_delivery'] = $request->cash_on_delivery;
        $data['admin_id'] = Auth::id();
        $data['date'] = date('d-m-Y');
        $data['month'] = date('F');
        $data['year'] = date('Y');



        // working with single image Thumbnail
        if ($request->thumbnail) {
            $slug = Str::slug($request->name, '-');
            $thumbnail = $request->thumbnail;
            $photoname = $slug . '.' . $thumbnail->getClientOriginalExtension();
            // $thumbnail->move('public/files/product/',$photoname); //without image intervention
            Image::make($thumbnail)->resize(600, 600)->save('public/files/product/' . $photoname); // image intervention

            $data['thumbnail'] = $photoname; //'public/files/product/' . $photoname
        }

        // working with multiple imags
        $images = array();
        if ($request->hasFile('images')) {
           foreach($request->file('images') as $key=>$image){

            $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            // $images->move('public/files/product/',$imageName); //without image intervention
            Image::make($image)->resize(600, 600)->save('public/files/product/' . $imageName ); // image intervention
            
            array_push($images,$imageName);

           }

           $data['images'] = json_encode($images);
        }

        DB::table('products')->insert($data);

        $notifications = array('messege' => 'Product Inserted', 'alert-type' => 'success');
        return redirect()->back()->with($notifications);


    }
}
