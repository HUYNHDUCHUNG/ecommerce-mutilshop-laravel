@extends('admin.layout')


@section('title')
    <h1>
        Order
    </h1>
@endsection

@section('content')
<div class="row">
    {{-- @if (session('msg'))
        <div class="col-md-5">
            <div class="alert alert-success" role="alert"
                style="background-color: #dff0d8 !important;border-color: #d6e9c6 !important;color: #3c763d !important">
                {{ session('msg') }}</div>
        </div>
    @endif --}}



    {{-- <div class="col-xs-12">
        <a href="{{ route('product.create') }}">
            <button class="btn btn-success">Add Product</button>
        </a>
    </div> --}}
    <div class="col-xs-12" style="margin:15px 0;">
        <div class="box">

            <div class="box-body table-responsive">
                <table class="table table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Date modified</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $key => $item)
                            <tr>
                                <td>#{{ $item->code }}</td>
                                
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->total_price }}</td>
                                <td>{{ $item->orderStatus->name }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                                
                                <td class="text-center"><a href="{{ route('order.detail',['id' => $item->id]) }}"><i class="fas fa-eye" style="font-size: 30px"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>

@endsection