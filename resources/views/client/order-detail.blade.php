@extends('client.layout')


{{-- @section('link')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection --}}

@section('content')
    <style>
        body {
            background: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }

        .text-reset {
            --bs-text-opacity: 1;
            color: inherit !important;
        }

        a {
            color: #5465ff;
            text-decoration: none;
        }
    </style>

    {{-- <div class="container-fluid"> --}}

        <div class="container">
            <!-- Title -->
            <div class="d-flex justify-content-between align-items-center py-3">
                <h2 class="h5 mb-0"><a href="#" class="text-muted"></a> Order #{{ $order->code }}</h2>
            </div>

            <!-- Main content -->
            <div class="row">
                <div class="col-lg-8">


                    <!-- Details -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between" style="padding: 8px">
                                <div style="display: flex; gap:10px">
                                    <span class="me-3 ">{{$order->created_at }}</span>
                                    <span class="me-3">#{{ $order->code }}</span>
                                    {{-- <span class="me-3">Visa -1234</span> --}}
                                    <span class="badge rounded-pill bg-blue " style="line-height: unset">{{ $order->orderStatus->name }}</span>
                                </div>
                                <div class="d-flex">
                                    <a class="btn btn-link p-0 me-3 d-none d-lg-block btn-icon-text " href="{{ route('invoice',['id' => $order->id]) }}" target="_blank"><i
                                            class="bi bi-download"></i> <span class="text">Invoice</span></a>
                                    {{-- <div class="dropdown">
                                        <button class="btn btn-link p-0 text-muted" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i>
                                                    Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-printer"></i>
                                                    Print</a></li>
                                        </ul>
                                    </div> --}}
                                </div>
                            </div>
                            <table class="table table-borderless">
                                <tbody>
                                    @foreach ($order_detail as $item)
                                    <tr class="pad-10">
                                        <td>
                                            <div class="d-flex mb-2" style="gap: 10px;align-items: center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ asset('storage/upload/' . $item->product->productImgs[0]->img_name) }}"
                                                        alt="" width="35" class="img-fluid">
                                                </div>
                                                <div class="flex-lg-grow-1 ms-3">
                                                    <h6 class="small mb-0"><a href="#" class="text-reset">{{ $item->product->product_name }}</a>
                                                    </h6>
                                                    <span class="small">{{ $item->color }}: {{ $item->size }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle;">{{ $item->quantity }}</td>
                                        <td class="text-right" style="vertical-align: middle;">{{ number_format($item->price * $item->quantity)}}</td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Subtotal</td>
                                        <td class="text-right">{{ number_format($order->total_price) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Shipping</td>
                                        <td class="text-right">FreeShip</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Discount (Code: NEWYEAR)</td>
                                        <td class="text-danger text-right">0</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="2">TOTAL</td>
                                        <td class="text-right">{{ number_format($order->total_price) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Payment -->
                    <div class="card mb-4">
                        <div class="card-body" style="padding: 10px">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="h6">Payment Method</h3>
                                    <p>Payment on delivery <br>
                                        Total: {{ number_format($order->total_price) }} <span class="badge bg-black rounded-pill">UNPAID</span></p>
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="h6">Billing address</h3>
                                    <address>
                                        <strong>{{ $order->fullname }}</strong><br>
                                        {{ $order->address }}
                                        {{-- 1355 Market St, Suite 900<br>
                                        San Francisco, CA 94103<br> --}}
                                        <br>
                                        <abbr title="Phone">P:</abbr> {{ $order->phonenumber }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Customer Notes -->
                    {{-- <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="h6">Customer Notes</h3>
                            <p>Sed enim, faucibus litora velit vestibulum habitasse. Cras lobortis cum sem aliquet mauris
                                rutrum. Sollicitudin. Morbi, sem tellus vestibulum porttitor.</p>
                        </div>
                    </div> --}}
                    {{-- <div class="card mb-4">
                        <!-- Shipping information -->
                        <div class="card-body">
                            <h3 class="h6">Shipping Information</h3>
                            <strong>FedEx</strong>
                            <span><a href="#" class="text-decoration-underline" target="_blank">FF1234567890</a> <i
                                    class="bi bi-box-arrow-up-right"></i> </span>
                            <hr>
                            <h3 class="h6">Address</h3>
                            <address>
                                <strong>John Doe</strong><br>
                                1355 Market St, Suite 900<br>
                                San Francisco, CA 94103<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
@endsection
