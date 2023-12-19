<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class ChildcategoryController extends Controller
{
    // for Authenticated user
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('childcategories')->leftjoin('categories', 'childcategories.category_id', 'categories.id')->leftjoin('subcategories', 'childcategories.subcategory_id', 'subcategories.id')->select('categories.category_name', 'subcategories.subcategory_name', 'childcategories.*')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionbtn = '<a href="#" class="btn btn-info btn-sm edit" data-id="{{ $row->id }}" 
                data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
    
                <a href="#" id="delete" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                return  $actionbtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.category.childcategory.index');

      
    }
}
