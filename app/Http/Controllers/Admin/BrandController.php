<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Support\Str;
use Image;

class BrandController extends Controller
{
     // for Authenticated user
     public function __construct()
     {
         $this->middleware('auth');
     }


     public function index(Request $request)
     {
         if ($request->ajax()) {
             $data = DB::table('brands')->get();
 
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id=" '.$row->id.' " 
                 data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
     
                 <a href="' .route('childcategory.delete',[$row->id]) .'" id="delete" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                     return  $actionbtn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
 
         return view('admin.category.brand.index');
     }
 
// store method

public function store(Request $request)
{

//     $image=$request->file('brand_logo');
// //    $exm = $request->request('brand_name');

//     dd($image);

    $validated = $request->validate([
        'brand_name' => 'required|unique:brands|max:55',
    ]);
    // quirybuilder
    $data = array();
    $data['brand_name'] = $request->brand_name;
    $data['brand_slug'] = Str::slug($request->brand_name, '-');
    // working wit image
    $slug = Str::slug($request->brand_name, '-');
    $photo = $request->brand_logo;
    $photoname = $slug.'.'.$photo->getClientOriginalExtension();
    $photo->move('public/files/brand/',$photoname); //without image intervention
    // Image::make($photo)->resize(240,120)->save('public/files/brand/'.$photoname); // image intervention

    $data['brand_logo'] = 'public/files/brand/'.$photoname;
   

    DB::table('brands')->insert($data);

    $notifications = array('messege' => 'Brand Inserted', 'alert-type' => 'success');
    return redirect()->back()->with($notifications);

}




}
