@extends('admin.layout')

@section('title')
<h1>
    Category
  </h1>
@endsection



@section('content')

<div class="row">
    @if((session('msg')))
        <div class="col-md-5">
            <div class="alert alert-success" role="alert" style="background-color: #dff0d8 !important;border-color: #d6e9c6 !important;color: #3c763d !important">{{ session('msg') }}</div>
        </div>
    @endif
    
    <div class="col-xs-12">
        <a href="{{ route('manage_category') }}">
            <button class="btn btn-success">Add Category</button>
        </a>
    </div>
    <div class="col-xs-10"  style="margin:15px 0;">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Category Table</h3>
          <div class="box-tools">
            <div class="input-group">
              <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search">
              <div class="input-group-btn">
                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <tbody><tr>
              <th>STT</th>
              <th>Name</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            @foreach ($categories as $key => $category)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $category->category_name }}</td>
                <td>@if($category->category_status == '0')
                    <span class="label label-danger">Inactive</span>
                    @else
                    <span class="label label-success">Active</span>
                    @endif
                </td>
                <td>
                  <div class="row">
                    <a href="{{ route('edit_category',['id'=>$category->id]) }}" class="col-xs-2"><button class="btn btn-info">Edit</button></a>
                    
                    <a href="{{ route('delete_category',['id'=>$category->id]) }}" class="col-xs-2"><button class="btn btn-danger">Delete</button></a>

                  </div>
                </td>
              </tr>
            @endforeach
            
          </tbody></table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>

@endsection