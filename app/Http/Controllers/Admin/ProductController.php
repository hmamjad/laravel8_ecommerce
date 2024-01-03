<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;
use Image;
use File;
use DataTables;
use App\Models\Product;


class ProductController extends Controller
{
    // for Authenticated user
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Product index/show method
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $imgurl = 'public/files/product';
            $data = Product::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('thumbnail',function($row) use($imgurl) {
                    return '<img src="'.$imgurl.'/'.$row->thumbnail.'" height="30" width="30">';
                })
                ->editColumn('category_name',function($row){
                    return $row->category->category_name;
                })
                ->editColumn('subcategory_name',function($row){
                    return $row->subcategory->subcategory_name;
                })
                ->editColumn('brand_name',function($row){
                    return $row->brand->brand_name;
                })
                ->editColumn('featured',function($row){
                    if($row->featured == 1){
                        return '<a href="#" data-id="'.$row->id.'" class="deactive_featured"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                    }else{
                        return '<a href="#" data-id="'.$row->id.'" class="active_featured"><i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">Deactive</span> </a>';
                    }
                })
                ->editColumn('today_deal',function($row){
                    if($row->today_deal == 1){
                        return '<a href="#" data-id="'.$row->id.'" class="deactive_deal"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                    }else{
                        return '<a href="#" data-id="'.$row->id.'" class="active_deal"><i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">Deactive</span> </a>';
                    }
                })
                ->editColumn('status',function($row){
                    if($row->status == 1){
                        return '<a href="#" data-id="'.$row->id.'" class="deactive_status"><i class="fas fa-thumbs-down text-danger"></i> <span class="badge badge-success">active</span> </a>';
                    }else{
                        return '<a href="#" data-id="'.$row->id.'" class="active_status"><i class="fas fa-thumbs-up text-success"></i> <span class="badge badge-danger">Deactive</span> </a>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionbtn = '<a href="#" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>

                                   <a href="#" class="btn btn-primary btn-sm edit"><i class="fas fa-eye"></i></a>
                                    
                                   <a href="' . route('product.delete', [$row->id]) . '" id="delete_product" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                    return  $actionbtn;
                })
                ->rawColumns(['action','category_name','subcategory_name','brand_name','thumbnail','featured','today_deal','status'])
                ->make(true);
        }

        $category = DB::table('categories')->get();
        $brand = DB::table('brands')->get();

        return view('admin.product.index',compact('category','brand'));
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
            foreach ($request->file('images') as $key => $image) {

                $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                // $images->move('public/files/product/',$imageName); //without image intervention
                Image::make($image)->resize(600, 600)->save('public/files/product/' . $imageName); // image intervention

                array_push($images, $imageName);
            }

            $data['images'] = json_encode($images);
        }

        DB::table('products')->insert($data);

        $notifications = array('messege' => 'Product Inserted', 'alert-type' => 'success');
        return redirect()->back()->with($notifications);
    }


    // Active to Deactive featured
    public function notfeatured($id){
        DB::table('products')->where('id',$id)->update(['featured' => 0]);
        return response()->json("Featured Deactived");
    }
    //  Deactive to Active featured
    public function activefeatured($id){
        DB::table('products')->where('id',$id)->update(['featured' => 1]);
        return response()->json("Featured Actived");
    }

    // Active to Deactive today_deal
    public function notdeal($id){
        DB::table('products')->where('id',$id)->update(['today_deal' => 0]);
        return response()->json("Deal Deactived");
    }

    // Deactive to Active  today_deal
    public function activedeal($id){
        DB::table('products')->where('id',$id)->update(['today_deal' => 1]);
        return response()->json("Deal Actived");
    }
    // Active to Deactive Status
    public function notstatus($id){
        DB::table('products')->where('id',$id)->update(['status' => 0]);
        return response()->json("Status Deactived");
    }

    // Deactive to Active  Status
    public function activestatus($id){
        DB::table('products')->where('id',$id)->update(['status' => 1]);
        return response()->json("Status Deactived");
    }

    // Product Delete
    public function destroy($id){
        DB::table('products')->where('id',$id)->delete();
        return response()->json("successfully Deleted!");
    }

    



}