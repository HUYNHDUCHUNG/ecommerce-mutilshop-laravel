@extends('client.layout')

@section('content')
<div class="container" style="min-height: 100vh; min-width: 90vw; margin-right: 0">
  <div class="row">
  <div class="bg-light p-4 mb-30 col-md-3" style="margin-right: 20px; height: 250px;">
    <form>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input filter active" id="status-all" data-status = "all">
            <label class="custom-control-label" for="status-all" >All</label>
            {{-- <span class="badge border font-weight-normal">1000</span> --}}
        </div>
        @foreach ($status as $item)
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
          <input type="checkbox" class="custom-control-input filter" id="status-{{ $item->id }}" data-status = {{ $item->id }}>
          <label class="custom-control-label" for="status-{{ $item->id }}" >{{ $item->name }}</label>
          {{-- <span class="badge border font-weight-normal">150</span> --}}
      </div>
        @endforeach

        
    </form>
</div>
<table class="table text-center mb-0 col-md-8" >
    <thead class="thead-light">
      <tr>
        <th>Mã đơn hàng</th>
        <th >Họ tên</th>
        <th>Điện thoại</th>
        <th>Địa chỉ</th>
        <th>Trạng thái</th>
        <th>Ngày đặt</th>
        <th>Chi tiết</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($order as $item)
      <tr>
        <th scope="row">#{{ $item->code }}</th>
        <td>{{ $item->fullname }}</td>
        <td>{{ $item->phonenumber }}</td>
        <td >{{ $item->address }}</td>
        <td style="width: 120px;">{{ $item->orderStatus->name }}</td>
        <td>{{ $item->created_at }}</td>
        <td style="width: 120px;"><a href="{{ route('user.order.detail',['id' => $item->id]) }}">Detail</a></td>
        @if ($item->status == 0)
        <td><a href="{{ route('user.cancel.order',['id' =>$item->id]) }}" class="btn btn-danger">Cancel</a></td>
        @endif
        
      </tr>
      @empty
      <tr>
          <td colspan="6">
            Orders are empty
          </td>
      </tr>
    @endforelse
      
    </tbody>
  </table>
</div>
</div>
@endsection

@section('js')

<script>
    $(document).ready(function(){
        $('.filter.active').prop("checked", true);
        $('.filter').on('change', function(){
            $('.filter.active').removeClass('active').prop("checked", false);
            $(this).addClass('active').prop("checked", true);
            var status = $(this).data('status');

            $.ajax({
                url: 'order-filter',
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