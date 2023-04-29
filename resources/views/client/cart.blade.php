@extends('client.layout')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
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
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>

                            <th>Size</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartDetails as $key => $item)
                            <tr data-id={{ $item->id }} class="item-cart">
                                <td class="align-middle"><img src="{{ asset('storage/upload/' . $img[$key]) }}"
                                        alt="" style="width: 50px;"></td>
                                <td>{{ $nameProduct[$key] }}</td>
                                <td class="align-middle">{{ number_format($item->price) }}</td>
                                <td class="align-middle">{{ $item->size }}</td>
                                <td class="align-middle">{{ $item->color }}</td>

                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto " style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $item->quantity }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle total">{{ number_format($item->price * $item->quantity) }}</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>$160</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
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
