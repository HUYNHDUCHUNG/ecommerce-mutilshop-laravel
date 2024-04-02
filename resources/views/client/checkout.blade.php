@extends('client.layout')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item " href="#">Trang chủ</a>
                    <a class="breadcrumb-item " href="#">Giỏ hàng</a>
                    <span class="breadcrumb-item active">Thanh toán</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <form action="{{ route('paypal.checkout') }}" method="POST" id="form-order">
        @csrf
        <!-- Checkout Start -->
        <div class="container-fluid">
            <div class="row px-xl-5">

                <div class="col-lg-12 mb-30">
                    <div class="bg-light boxshadow-custom p-30" style="border-radius: 10px">
                        <h5 class="section-title position-relative text-uppercase mb-3">Địa chỉ giao hàng</h5>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Họ và tên:</label>
                                    <input class="form-control input_name" type="text" placeholder="John"
                                        value="{{ $user->name }}" name="fullName">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Số điện thoại:</label>
                                    <input class="form-control input_phone" type="text" placeholder="Phone Number"
                                        value="{{ $user->phonenumber }}" name="phoneNumber">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Tỉnh thành:</label>
                                    <select class="custom-select" name="province" id="loadProvince">
                                        <option selected disabled>------Chọn tỉnh thành------</option>
                                        @foreach ($province as $item)
                                            <option {{ $user->province == $item->province_id ? 'selected' : '' }}
                                                value="{{ $item->province_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Thành phố:</label>
                                    <select class="custom-select" id="loadDistrict" name="district">
                                        <option selected disabled>------Chọn thành phố------</option>
                                        @foreach ($district as $item)
                                            <option {{ $user->district == $item->district_id ? 'selected' : '' }}
                                                value="{{ $item->district_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Phường, xã:</label>
                                    <select class="custom-select" id="loadWard" name="ward">
                                        <option selected disabled>------Chọn phường, xã------</option>
                                        @foreach ($ward as $item)
                                            <option {{ $user->ward == $item->wards_id ? 'selected' : '' }}
                                                value="{{ $item->wards_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Địa chỉ cụ thể:</label>
                                    <input class="form-control input_address" type="text" placeholder="123 Street"
                                        name="address" value="{{ $user->address }}">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12  mb-30">
                    <div class="bg-light boxshadow-custom p-30" style="border-radius: 10px">

                        <h5 class="section-title position-relative text-uppercase mb-3">Tổng đơn hàng</h5>
                        <div class="bg-light">
                            <div>
                                <table class="text-center table table-checkout">
                                    <tr>
                                        <th class="text-left">
                                            <h5>Sản phẩm</h5>
                                        </th>
                                        <th>
                                            <span style="color: grey"> Phân loại </span>
                                        </th>
                                        <th> <span style="color: grey">Số lượng </span></th>
                                        <th> <span style="color: grey">Đơn giá </span></th>
                                        <th class="text-right"> <span style="color: grey">Tổng giá </span></th>
                                    </tr>
                                    @forelse ($cartDetails as $key => $item)
                                        <tr data-id={{ $item->id }} class="item-cart text-left">
                                            <td class="align-middle"> <a href="#"><img
                                                        src="{{ asset('storage/upload/' . $img[$key]) }}" alt=""
                                                        style="width: 40px;">
                                                    <span style="padding-left: 20px">{{ $nameProduct[$key] }}</span></a>
                                            </td>
                                            {{-- <td></td> --}}

                                            <td class="text-center">Phân loại: <small>{{ $item->size }},
                                                    {{ $item->color }}</small></td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-center">{{ number_format($item->price) }}<small>đ</small></td>
                                            <td class="text-right">
                                                {{ number_format($item->price * $item->quantity) }}<small>đ</small></td>

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                There are no products in the cart
                                            </td>
                                        </tr>
                                    @endforelse

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td>Tổng ({{ $quantity_all }} sản phẩm):</td>
                                        <td class="text-right">{{ number_format($total_all) }}<small>đ</small></td>
                                    </tr>
                                </table>
                                <input type="hidden" value="{{ $quantity_all }}" name="total_quantity">
                                <input type="hidden" value="{{ $total_all }}" name="total_price">
                            </div>


                        </div>
                    </div>
                </div>


                <div class="col-lg-12 ">
                    <div class="bg-light boxshadow-custom p-30" style="border-radius: 10px">
                        <h5 class="section-title position-relative text-uppercase mb-3">Thanh toán</h5>

                        <div class="mb-5">

                            <div class="row">
                                <div class="col-md-8 text-left">
                                    <h6>Phương thức thanh toán</h6>
                                </div>
                                <div class="col-md-4 text-right border-bottom">
                                    <h6>Thanh toán khi nhận hàng</h6>
                                </div>

                            </div>
                            <div class="row border-bottom">

                                <div class="col-md-8">
                                    <table class="table table_payment-method">
                                        <tr>
                                            <td>
                                                <div>
                                                    <input value="paypal" name="payment_method" type="radio">
                                                    <img src="{{ asset('client/img/paypal.png') }}" alt="">
                                                    <span>Payment via Paypal</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input value="cod" name="payment_method" type="radio" checked>
                                                    <img src="{{ asset('client/img/payment-cod.png') }}" alt="">
                                                    <span>Payment on delivery</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div>
                                                    <input value="momo" name="payment_method" type="radio">
                                                    <img src="{{ asset('client/img/payment-momo.png') }}" alt="">
                                                    <span>Payment by Momo</span>
                                                </div>
                                            </td>
                                        </tr>


                                    </table>
                                </div>
                                <div class="col-md-4 ">
                                    <table class="table table_payment">
                                        <tr>
                                            <td>Total:</td>
                                            <td class="text-right">{{ number_format($total_all) }}<small>đ</small></td>
                                        </tr>
                                        <tr>
                                            <td>Transport fee</td>
                                            <td class="text-right">Free ship</td>
                                        </tr>
                                        <tr>
                                            <td>Total payment</td>
                                            <td class="text-right">{{ number_format($total_all) }}<small>đ</small></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <div class="row" style="padding: 15px 0">
                                <div class="col-md-8 text-left">
                                    <p>Clicking "Place Order" means that you agree to abide by the Multishop Terms</p>
                                </div>
                                <div class="col-md-4 text-right">
                                    @if ($quantity_all == 0)
                                        <a href="{{ route('product') }}" class="btn btn-warning btn-lg"
                                            style="padding: 5px 25px;font-weight: 700; border-radius: 4px">Shopping</a>
                                    @else
                                        <button type="submit" class="btn btn-custom-shop btn-lg btn-submit "
                                            style="padding: 5px 25px;font-weight: 700; border-radius: 4px">Order</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Checkout End -->
@endsection

@section('js')
    <script src="{{ asset('client/js/sweetalert2@11.js') }}"></script>
    <script>
        $(function() {
            $('#loadProvince').on('change', function() {
                var id_province = $(this).val();

                $.ajax({
                    url: '/district',
                    method: 'GET',
                    data: {
                        id_province: id_province,
                    },
                    success: function(data) {
                        $('#loadDistrict').html(data);
                    }
                })
            })


            $('#loadDistrict').on('change', function() {
                var id_district = $(this).val();
                $.ajax({
                    url: '/ward',
                    method: 'GET',
                    data: {
                        id_district: id_district,
                    },
                    success: function(data) {

                        $('#loadWard').html(data);
                    }
                })
            })

            $('.btn-submit').on('click', function(e) {
                e.preventDefault();
                let province = $('#loadProvince option:selected').text()
                let district = $('#loadDistrict option:selected').text()
                let ward = $('#loadWard option:selected').text()
                let address = $('.input_address').val()
                let address_full = province + "," + district + "," + ward + "," + address
                var fullname = $('.input_name').val()
                var phone = $('.input_phone').val()
                // Thêm các thông tin khác của đơn hàng tương tự


                Swal.fire({
                    title: 'Are you sure?',
                    text: "aaa",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-order').submit();
                    }
                })

                var message = "<p>You won't be able to revert this!</p>" +
                    "<p>Name: " + fullname +
                    "</p> <p>Phone: " + phone + "</p>" +
                    "<p>Address:" + address_full + "</p>"

                console.log(message);
                $('#swal2-html-container').html(message);
            });



        })
    </script>
@endsection
