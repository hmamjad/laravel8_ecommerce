@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Child-Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#subcategoryModal">+ Add
                                new</button>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- Content Header End-->


        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Child-Category list here</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="" class="table table-bordered table-striped table-sm ytable">
                                    <thead>
                                        <tr>
                                            <th>#SL</th>
                                            <th>Child-Category Name</th>
                                            <th>Sub-Category Name</th>
                                            <th>Category Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>


    <!-- Main content -->


    <!-- Subcategory insert Modal  -->
    <div class="modal fade" id="subcategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new Child-Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('subcategory.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        {{-- Category select --}}
                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <select class="form-control" name="category_id" id="">

                                {{-- @foreach ($category as $row)
                                    <option value="{{ $row->id }}">{{ $row->category_name }}</option>
                                @endforeach --}}

                            </select>
                        </div>
                         {{-- sub category   --}}
                        <div class="form-group">
                            <label for="subcategory_name">Sub-Category Name</label>
                            <input type="text" class="form-control" id="subcategory_name" name="subcategory_name"
                                required="">
                            <small id="emailHelp" class="form-text text-muted">This is your subcategory</small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit SubCategory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal_body">
                   
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
        $(function childcategory(){
            var table = $('.ytable').DataTable({
                processing: true,
                serverSide:true,
                ajax:'{{route('childcategory.index')}}',
                columns:[
                    {data:'DT_RowIndex',name:'DT_RowIndex'},
                    {data:'childcategory_name',name:'childcategory_name'},
                    {data:'subcategory_name',name:'subcategory_name'},
                    {data:'category_name',name:'category_name'},
                    {data:'action',name:'action',orderable:true,searchable:true},
                ]
            })
        })
    </script>
@endsection
<!-- /.content-header -->
