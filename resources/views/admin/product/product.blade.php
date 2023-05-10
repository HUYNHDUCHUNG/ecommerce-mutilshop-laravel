@extends('admin.layout')


@section('title')
    <h1>
        Product
    </h1>
@endsection



@section('content')
    <div class="row">
        @if (session('msg'))
            <div class="col-md-5">
                <div class="alert alert-success fade in" role="alert"
                    style="background-color: #dff0d8 !important;border-color: #d6e9c6 !important;color: #3c763d !important">
                    {{ session('msg') }}</div>
            </div>
        @endif



        <div class="col-xs-12">
            <a href="{{ route('product.create') }}">
                <button class="btn btn-success">Add Product</button>
            </a>
        </div>
        <div class="col-xs-12" style="margin:15px 0;">
            <div class="box">

                <div class="box-body table-responsive">
                    <table class="table table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                {{-- <th>Description</th> --}}
                                <th style="text-align: center">Featured</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('storage/upload/' . $item->productImgs['0']->img_name) }}"
                                            style="width: 100px; display: block">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>{{ $item->product_price }}</td>
                                    <td>{{ $item->product_quantity }}</td>
                                    <td>{{ $item->getCategory->category_name }}</td>
                                    
                                    {{-- <td >
                                    <div style="word-wrap: break-word;
                                    white-space: normal;
                                    overflow: hidden;
                                    display: -webkit-box;
                                    text-overflow: ellipsis;
                                    -webkit-box-orient: vertical;
                                    -webkit-line-clamp: 2;">
                                        {{ $item->product_description }}
                                    </div> --}}
                                    </td>
                                    <td style="text-align: center"><a href="" class="btn_featured" data-id = "{{ $item->id }}"><i style="font-size: 25px;" class="{{ $item->product_featured == 0 ? "far" : "fas"}} fa-star"></i></a></td>
                                    <td style="display: flex; gap : 10px">
                                        <a href="{{ route('product.edit',[$item->id]) }}"><button type="button" class="btn btn-primary">Edit</button></a>

                                        <form action="{{ route('product.destroy', [$item->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@endsection

@section("js")
    <script>
    


    $(function(){
        $(".btn_featured").on("click", function(e){
            e.preventDefault();
            var id = $(this).data("id");
            var btn = $(this);
            
            $.ajax({
                url: "/admin/product/featured",
                method: "POST",
                dataType: "json",

                data:{
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id : id,
                    
                },

                success: function(data){
                    btn.children().toggleClass("fas")
                    btn.children().toggleClass("far")
                    
                }


            })

            
        })
     })
    </script>
@endsection