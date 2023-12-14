@extends('layouts.admin')

@section('admin_content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Category</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Category</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                                <h3 class="card-title">All Category list here</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                  <tr>
                                    <th>#SL</th>
                                    <th>Category Name</th>
                                    <th>Category Slug</th>
                                    <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                    <td>1</td>
                                    <td>HP</td>
                                    <td>hp ,laptop</td>
                                    <td>Edit</td>
                                  </tr>
                                 
                                  </tbody>
                                  <tfoot>
                                  <tr>
                                    <td>#SL</td>
                                    <td>Category Name</td>
                                    <td>Category Slug</td>
                                    <td>Action</td>
                                  </tr>
                                  </tfoot>
                                </table>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>


    <!-- Main content -->
    

@endsection
<!-- /.content-header -->
