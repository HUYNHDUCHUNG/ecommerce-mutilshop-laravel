@extends('admin.layout')

@section('title')
    <h1>
        Add Category
    </h1>
@endsection



@section('content')
    <div class="col-md">

        <a href="{{ route('category') }}" >
            <button class="btn btn-primary" style="padding: 5px 20px">Back</button>
        </a>

        <div class="box box-primary" style="margin:15px 0;">
            <div class="box-header">
                <h3 class="box-title">Quick Example</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="row">
                <div class="col-xs-8">
                    <form role="form" method="post">
                        @csrf
                        <div class="box-body">
                            <div class="form-group col-md-6" >
                                <label for="exampleInputEmail1">Category Name:</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    placeholder="Enter category name" name="name" required value="{{ $model->category_name??null }}">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="sel1">Status:</label>
                                <select class="form-control" id="sel1" name="status">
                                  <option value="0" {{ $model->category_status != '0'? '':'selected' }}>Inactive</option>
                                  <option value="1" {{ $model->category_status != '1'? '':'selected' }}>Active</option>
                                </select>
                              </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer col-md-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
