@extends('client.layout')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item" href="#">Trang chủ</a>
                    <span class="breadcrumb-item active">Sản phẩm</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <div class="bg-light p-4 boxshadow-custom" style="border-radius: 8px; height: fit-content;">
                    <h5 class="">Lọc theo giá</h5>
                    <div class="mb-30">
                        <form>
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter active" id="price-all"
                                    data-filter_min = "0" data-filter_max = "0">
                                <label class="custom-control-label" for="price-all">All Price</label>
                                <span class="badge border font-weight-normal">1000</span>
                            </div>
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter" id="price-1"
                                    data-filter_min = "0" data-filter_max = "100000">
                                <label class="custom-control-label" for="price-1">0đ - 100K</label>
                                <span class="badge border font-weight-normal">150</span>
                            </div>
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter" id="price-2"
                                    data-filter_min = "100000" data-filter_max = "300000">
                                <label class="custom-control-label" for="price-2">100K - 300K</label>
                                <span class="badge border font-weight-normal">295</span>
                            </div>
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter" id="price-3"
                                    data-filter_min = "300000" data-filter_max = "1000000">
                                <label class="custom-control-label" for="price-3">300K - 1000K</label>
                                <span class="badge border font-weight-normal">246</span>
                            </div>
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input filter" id="price-4"
                                    data-filter_min = "1000000" data-filter_max = "9999999999999">
                                <label class="custom-control-label" for="price-4">1000K - Trở lên</label>
                                <span class="badge border font-weight-normal">145</span>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">


                    <div class="col-12 pb-1">
                        <div class="bg-light boxshadow-custom p-4" style="border-radius: 8px; ">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                    <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                                </div>
                                <div class="ml-2">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                            data-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Latest</a>
                                            <a class="dropdown-item" href="#">Popularity</a>
                                            <a class="dropdown-item" href="#">Best Rating</a>
                                        </div>
                                    </div>
                                    <div class="btn-group ml-2">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                            data-toggle="dropdown">Showing</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">10</a>
                                            <a class="dropdown-item" href="#">20</a>
                                            <a class="dropdown-item" href="#">30</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       

                        <div class="box-item" style="display: flex; flex-wrap: wrap">
                            @foreach ($product as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100"
                                                src="{{ asset('storage/upload/' . $item->productImgs['0']->img_name) }}"
                                                alt="">
                                            <div class="product-action">
                                                {{-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a> --}}
                                                <a class="btn btn-outline-dark btn-square"
                                                    href="{{ route('product-detail', ['id' => $item->id]) }}"><i
                                                        class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href=""
                                                style="display: flex">{{ $item->product_name }}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>{{ number_format($item->product_price) }}</h5>
                                                <h6 class="text-muted ml-2">
                                                    <del>{{ number_format($item->product_price) }}</del>
                                                </h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small>(99)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    
                        <div class="col-12">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item disabled"><a class="page-link"
                                            href="#">Previous</span></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.filter.active').prop("checked", true);
            $('.filter').on('change', function() {
                $('.filter.active').removeClass('active').prop("checked", false);
                $(this).addClass('active').prop("checked", true);
                var filter_min = $(this).data('filter_min');
                var filter_max = $(this).data('filter_max');
                // console.log(typeof filter_min,typeof filter_max);
                $.ajax({
                    url: 'product-filter',
                    method: 'GET',
                    data: {
                        filter_min: filter_min,
                        filter_max: filter_max,
                    },
                    success: function(data) {
                        $('.box-item').html(data);


                        // data.forEach(element => {
                        //     console.log(element.id);
                        // });
                        // var box = $('.box');
                        // box.html('');
                        // data.forEach(e => {
                        // box.append(
                        // `<div class="col-lg-4 col-md-6 col-sm-6 pb-1"> 
                    //     <div class="product-item bg-light mb-4">
                    //         <div class="product-img position-relative overflow-hidden">
                    //             <img class="img-fluid w-100" src="http://127.0.0.1:8000/storage/upload/" alt="">
                    //             <div class="product-action">
                    //                 {{-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a> --}}
                    //                 <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                    //             </div>
                    //         </div>
                    //         <div class="text-center py-4">
                    //             <a class="h6 text-decoration-none text-truncate" href=""></a>
                    //             <div class="d-flex align-items-center justify-content-center mt-2">
                    //                 <h5></h5><h6 class="text-muted ml-2"><del></del></h6>
                    //             </div>
                    //             <div class="d-flex align-items-center justify-content-center mb-1">
                    //                 <small class="fa fa-star text-primary mr-1"></small>
                    //                 <small class="fa fa-star text-primary mr-1"></small>
                    //                 <small class="fa fa-star text-primary mr-1"></small>
                    //                 <small class="fa fa-star text-primary mr-1"></small>
                    //                 <small class="fa fa-star text-primary mr-1"></small>
                    //                 <small>(99)</small>
                    //             </div>
                    //         </div>
                    //     </div>
                    // </div>`
                        // )
                        // });

                    }

                })

            })



        })
    </script>
@endsection
