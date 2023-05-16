@extends('admin.layout')


@section('title')
    <h1>
        Customer
    </h1>
@endsection

@section('content')
<div class="row">
    
    <div class="col-xs-12">
        <a href="{{ route('export.users') }}">
            <button class="btn btn-info">Export</button>
        </a>
    </div>
    <div class="col-xs-12" style="margin:15px 0;">
        <div class="box">

            <div class="box-body table-responsive">
                
                <table class="table table-hover" id="myTable">
                    <div class="form-group">
                    <thead>
                        <tr>
                            
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Create At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer as $key => $item)
                            <tr>
                                <td>#{{ $key }}</td>
                                
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phonenumber }}</td>
                                <td>{{ ($item->address == null && $item->province == null && $item->district == null && $item->ward == null) ? 'Chưa cập nhật' :
                                    App\Models\Province::where('province_id', $item->province)->first()->name . ',' .
                                    App\Models\District::where('district_id', $item->district)->first()->name . ',' .
                                    App\Models\Ward::where('wards_id', $item->ward)->first()->name . ',' .
                                    $item->address
                                }}</td>
                                <td>{{ $item->created_at }}</td>
                                
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>

@endsection