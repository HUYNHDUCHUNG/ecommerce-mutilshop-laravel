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
                    <div class="form-group">
                        <label for="sel1">Status:</label>
                        <select name="" id="status" class="form-group">
                            <option value="all">All Status</option>
                            <option value="0">Pendding</option>
                            <option value="1">Delivered</option>
                            <option value="2">Completed</option>
                            <option value="3">Cancelled</option>
                        </select>
                        </div>
                    <thead>
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>Code</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th>Date modified</th>
                            <th>View</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $key => $item)
                            <tr>
                                <th><input type="checkbox"></th>
                                <td>#{{ $item->code }}</td>
                                
                                <td>{{ $item->fullname }}</td>
                                <td>{{ $item->total_price }}</td>
                                <td>{{ $item->orderStatus->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y H:i:s') }}</td>
                                
                                <td class="text-center">
                                    <a href="{{ route('order.detail',['id' => $item->id]) }}"><i class="fas fa-eye" style="font-size: 30px"></i></a>
                                    
                                </td>
                                <td>
                                    @if($item->orderStatus->id == 0)
                                        <a href="{{ route('order.confirm',['id' => $item->id]) }}" class="btn btn-info" style="width: 90.59px">Confirm</a>
                                    @elseif ($item->orderStatus->id == 1)
                                        <a href="{{ route('order.completed',['id' => $item->id]) }}"  class="btn btn-success">Completed</a>
                                    @endif
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
@section('js')

<script>
    $(document).ready(function(){
        
        $('#status').on('change', function(){
            var status = $(this).val();
            $.ajax({
                url: 'order-filters',
                method: 'GET',
                data:{
                   status : status,
                },
                success: function(data){
                    $('tbody').html(data);
                    
                }

            })

        })


    })


    
</script>

@endsection