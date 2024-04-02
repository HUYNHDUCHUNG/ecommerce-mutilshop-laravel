@extends('client.layout')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item" href="#">Trang chủ</a>
                    <span class="breadcrumb-item active">Giỏ hàng</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá tiền</th>

                            <th>Size</th>
                            <th>Màu sắc</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartDetails as $key => $item)
                            <tr data-id={{ $item->id }} class="item-cart">
                                <td class="align-middle"><img src="{{ asset('storage/upload/' . $img[$key]) }}"
                                        alt="" style="width: 80px; border-radius: 4px"></td>
                                <td>{{ $nameProduct[$key] }}</td>
                                <td class="align-middle">{{ number_format($item->price) }}</td>
                                <td class="align-middle">{{ $item->size }}</td>
                                <td class="align-middle" style="width: 90px;">{{ $item->color }}</td>

                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto ">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-custom-shop btn-minus">
                                                <i class="fa fa-minus btn-icon"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $item->quantity }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-custom-shop btn-plus">
                                                <i class="fa fa-plus btn-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle total" style="width: 100px;">
                                    {{ number_format($item->price * $item->quantity) }}</td>
                                <td class="align-middle" style="width: 120px;"><button class="btn btn-sm btn-danger"><i
                                            class="fa fa-times btn-icon"></i></button></td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                {{-- <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form> --}}
                <div class="bg-light boxshadow-custom p-4" style="border-radius: 8px">


                    <h5 class="section-title position-relative text-uppercase mb-5">Tóm tắt giỏ hàng</h5>
                    <div class="bg-light mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6>{{ number_format($total_all) }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">Free ship</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5>{{ number_format($total_all) }}</h5>
                            </div>
                            <a href="{{ route('checkout') }}"
                                class="btn btn-block font-weight-bold my-3 py-3 btn-custom-shop" style="border-radius: 4px">Proceed To Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('js')
    <script src="{{ asset('client/js/sweetalert2@11.js') }}"></script>
    <script>
        $(function() {





            $('.btn-minus').on('click', function() {
                // alert( $(this).closest('.item-cart').data('id'));
                var btn = $(this)

                var quantity = $(this).closest('.quantity').find('input').first().val();
                if (quantity == 0) {

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'

                            )

                            $(this).closest('.item-cart').find('.btn-danger').click();

                        } else {
                            $(this).closest('.quantity').find('input').first().val(1);
                            $.ajax({
                                url: '/plus-quanity',
                                method: 'GET',
                                data: {
                                    'id': btn.closest('.item-cart').data('id'),
                                },
                                // dataType: 'text',
                                success: function(data) {
                                    // alert(data);
                                    btn.closest('.item-cart').find('.total').first()
                                        .html(data);
                                }
                            })
                        }
                    })

                }
                $.ajax({
                    url: '/minus-quanity',
                    method: 'GET',
                    data: {
                        'id': btn.closest('.item-cart').data('id'),
                    },
                    // dataType: 'text',
                    success: function(data) {
                        // alert(data);
                        btn.closest('.item-cart').find('.total').first().html(data);

                    }
                })
            })


            $('.btn-plus').on('click', function() {
                // alert( $(this).closest('.item-cart').data('id'));
                var btn = $(this)
                $.ajax({
                    url: '/plus-quanity',
                    method: 'GET',
                    data: {
                        'id': btn.closest('.item-cart').data('id'),
                    },
                    // dataType: 'text',
                    success: function(data) {
                        // alert(data);
                        btn.closest('.item-cart').find('.total').first().html(data);
                    }
                })
            })

            $('.btn-danger').on('click', function() {
                // alert( $(this).closest('.item-cart').data('id'));
                var btn = $(this)
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'

                        )
                        $.ajax({
                            url: '/remove-item-cart',
                            method: 'GET',
                            data: {
                                'id': btn.closest('.item-cart').data('id'),
                            },
                            // dataType: 'text',
                            success: function(data) {
                                // alert(data);
                                btn.closest('.item-cart').fadeOut('slow');
                            }
                        })
                    }
                })

            })
        })
    </script>
@endsection
