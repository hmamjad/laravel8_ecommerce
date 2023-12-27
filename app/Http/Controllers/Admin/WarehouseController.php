<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class WarehouseController extends Controller
{
    // for Authenticated user
    public function __construct()
    {
        $this->middleware('auth');
    }

     // show warehouse with yajra datatable
     public function index(Request $request)
     {
         if ($request->ajax()) {
             $data = DB::table('warehouses')->latest()->get();
 
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id=" '.$row->id.' " 
                 data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
     
                 <a href="' .route('warehouse.delete',[$row->id]) .'" id="delete" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                    
                 return  $actionbtn;
                 })
                 ->rawColumns(['action'])
                 ->make(true);
         }
 
         return view('admin.category.warehouse.index');
     }


    // store method warehouse

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_name' => 'required|unique:warehouses',
        ]);

        // quirybuilder
        $data = array();
        $data['warehouse_name'] = $request->warehouse_name;
        $data['warehouse_address'] = $request->warehouse_address;
        $data['warehouse_phone'] = $request->warehouse_phone;

        DB::table('warehouses')->insert($data);

        $notifications = array('messege' => 'Warehouse Inserted', 'alert-type' => 'success');
        return redirect()->back()->with($notifications);
    }

    // delete method warehouse

    public function destroy($id){
        DB::table('warehouses')->where('id',$id)->delete();
        $notifications = array('messege' => 'Warehouse Deleted', 'alert-type' => 'success');
        return redirect()->back()->with($notifications);
    }


}
