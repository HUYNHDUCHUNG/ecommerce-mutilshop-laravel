@extends('admin.layout')

@section('title')
    <h1>
        Add Product
    </h1>
@endsection



@section('content')
    <div class="col-md">

        <a href="{{ route('product.index') }}">
            <button class="btn btn-primary" style="padding: 5px 20px">Back</button>
        </a>

        <div class="box box-primary" style="margin:15px 0;">
            <div class="box-header">
                <h3 class="box-title">Add product</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="row">
                <div class="col-xs-10">
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <form method="POST" enctype="multipart/form-data" action="{{ route('product.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlFile1">Image file input</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1"
                                    name="nameFile[]" multiple>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputAddress">Input Name Product:</label>
                                <input type="text" class="form-control" id="inputAddress" name="name">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Input Price:</label>
                                <input type="number" class="form-control" id="inputEmail4" name="price">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Input Quantity:</label>
                                <input type="number" class="form-control" id="inputEmail4" name="quantity">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Input Brand:</label>
                                <input type="text" class="form-control" id="inputPassword4" name="brand">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">Category</label>
                                <select id="inputState" class="form-control" name="category">
                                    @foreach ($category as $item)
                                    <option value ="{{ $item->id }}">{{ $item->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputAddress">Description</label>
                                <textarea class="form-control" id="my-editor" cols="50" rows="10" name="description"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
{{-- <script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
</script> --}}
<script>
    CKEDITOR.replace('my-editor');
    </script>
@endsection
