@extends('admin.layout')

@section('title')
    <h1>
        Edit Product
    </h1>
@endsection



@section('content')
    <div class="col-md">

        <a href="{{ route('product.index') }}">
            <button class="btn btn-primary" style="padding: 5px 20px">Back</button>
        </a>

        <div class="box box-primary" style="margin:15px 0;">
            <div class="box-header">
                <h3 class="box-title">Edit product</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="row">
                <div class="col-xs-10">
                    <form method="POST" enctype="multipart/form-data" action="{{ route('product.update',[$product->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlFile1">Image file input</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1"
                                    name="nameFile[]" multiple>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputAddress">Input Name Product:</label>
                                <input type="text" class="form-control" id="inputAddress" name="name" value="{{ $product->product_name }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Input Price:</label>
                                <input type="number" class="form-control" id="inputEmail4" name="price" value="{{ $product->product_price }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Input Quantity:</label>
                                <input type="number" class="form-control" id="inputEmail4" name="quantity" value="{{ $product->product_quantity }}">
                            </div>

                            <div class="form-group col-md-3">
                                <label for="inputPassword4">Input Brand:</label>
                                <input type="text" class="form-control" id="inputPassword4" name="brand" value="{{ $product->product_brand }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputState">Category</label>
                                <select id="inputState" class="form-control" name="category" >
                                    @foreach ($category as $item)
                                    <option value ="{{ $item->id }}" {{ ($item->id == $product->category_id) ? "selected":'' }} >{{ $item->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputAddress">Description</label>
                                <textarea class="form-control" id="inputAddress" cols="50" rows="10" name="description" >{{ $product->product_description }}</textarea>
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
@endsection
