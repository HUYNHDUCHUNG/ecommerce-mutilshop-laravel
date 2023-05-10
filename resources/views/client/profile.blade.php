@extends('client.layout')

@section('content')
    <style>
        .padding {
            padding: 3rem !important
        }

        .user-card-full {
            overflow: hidden;
        }

        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            border: none;
            margin-bottom: 30px;
        }

        .m-r-0 {
            margin-right: 0px;
        }

        .m-l-0 {
            margin-left: 0px;
        }

        .user-card-full .user-profile {
            border-radius: 5px 0 0 5px;
        }

        .bg-c-lite-green {
            background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
            background: linear-gradient(to right, #ee5a6f, #f29263);
        }

        .user-profile {
            padding: 20px 0;
        }

        .card-block {
            padding: 1.25rem;
        }

        .m-b-25 {
            margin-bottom: 25px;
        }

        .img-radius {
            border-radius: 5px;
        }



        h6 {
            font-size: 14px;
        }

        .card .card-block p {
            line-height: 25px;
        }

        @media only screen and (min-width: 1400px) {
            p {
                font-size: 14px;
            }
        }

        .card-block {
            padding: 1.25rem;
        }

        .b-b-default {
            border-bottom: 1px solid #e0e0e0;
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .p-b-5 {
            padding-bottom: 5px !important;
        }

        .card .card-block p {
            line-height: 25px;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .text-muted {
            color: #919aa3 !important;
        }

        .b-b-default {
            border-bottom: 1px solid #e0e0e0;
        }

        .f-w-600 {
            font-weight: 600;
        }

        .m-b-20 {
            margin-bottom: 20px;
        }

        .m-t-40 {
            margin-top: 20px;
        }

        .p-b-5 {
            padding-bottom: 5px !important;
        }

        .m-b-10 {
            margin-bottom: 10px;
        }

        .m-t-40 {
            margin-top: 20px;
        }

        .user-card-full .social-link li {
            display: inline-block;
        }

        .user-card-full .social-link li a {
            font-size: 20px;
            margin: 0 10px 0 0;
            -webkit-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }
    </style>



<form action="{{ route('user.edit_profile') }}" method="post">
    @csrf
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="row">
                
                    <div class="col-lg-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-4 bg-c-lite-green user-profile">
                                    <div class="text-center text-white">
                                        <div class="m-b-25">
                                            <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius"
                                                alt="User-Profile-Image">
                                        </div>
                                        <h6 class="f-w-600">{{ $user->name }}</h6>
                                        {{-- <p>Web Designer</p> --}}
                                        <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Full Name:</p>
                                                <input class="form-control" type="text" value="{{ $user->name }}"
                                                    name="fullname">
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Phone:</p>
                                                <input class="form-control" type="text" value="{{ $user->phonenumber }}"
                                                    name="phonenumber">
                                            </div>
                                        </div>
                                        {{-- <div class="row" style="padding-top: 10px">
                                                <div class="col-sm-6" style="display: flex; gap: 20px">
                                                    <p class="m-b-10 f-w-600">Gender:</p>
                                                    <div>
                                                        <label for="">Male</label>
                                                        <input type="radio" name="sex">
                                                    </div>

                                                    <div>
                                                        <label for="">Female</label>
                                                        <input type="radio" name="sex">
                                                    </div>
                                                </div>


                                            </div> --}}
                                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Address</h6>
                                        <div class="row" style="padding-top: 10px">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Province</p>
                                                <select class="custom-select" name="province" id="loadProvince">
                                                    <option selected disabled>------Choose Province------</option>
                                                    @foreach ($province as $item)
                                                        <option {{ $user->province == $item->province_id ? 'selected' : '' }}
                                                            value="{{ $item->province_id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">District</p>
                                                <select class="custom-select" id="loadDistrict" name="district">
                                                    <option selected disabled>------Choose District------</option>
                                                    @foreach ($district as $item)
                                                        <option {{ $user->district == $item->district_id ? 'selected' : '' }}
                                                            value="{{ $item->district_id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-top: 10px">
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Ward</p>
                                                <select class="custom-select" id="loadWard" name="ward">
                                                    <option selected disabled>------Choose Ward------</option>
                                                    @foreach ($ward as $item)
                                                        <option {{ $user->ward == $item->wards_id ? 'selected' : '' }}
                                                            value="{{ $item->wards_id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="m-b-10 f-w-600">Specific Address</p>
                                                <input class="form-control" type="text" value="{{ $user->address }}"
                                                    name="specific">
                                            </div>
                                        </div>
                                        <button class="btn btn-info" style="margin-top: 20px" type="submit">Save</button>
                                        {{-- <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Projects</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Recent</p>
                                            <h6 class="text-muted f-w-400">Sam Disuja</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="m-b-10 f-w-600">Most Viewed</p>
                                            <h6 class="text-muted f-w-400">Dinoter husainm</h6>
                                        </div>
                                    </div> --}}
                                        {{-- <ul class="social-link list-unstyled m-t-40 m-b-10">
                                        <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                                data-original-title="facebook" data-abc="true"><i
                                                    class="mdi mdi-facebook feather icon-facebook facebook"
                                                    aria-hidden="true"></i></a></li>
                                        <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                                data-original-title="twitter" data-abc="true"><i
                                                    class="mdi mdi-twitter feather icon-twitter twitter"
                                                    aria-hidden="true"></i></a></li>
                                        <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title=""
                                                data-original-title="instagram" data-abc="true"><i
                                                    class="mdi mdi-instagram feather icon-instagram instagram"
                                                    aria-hidden="true"></i></a></li>
                                    </ul> --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                
            </div>

        </div>
    </div>
</form>
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

            // $('.btn-submit').on('click',function(e){
            //     e.preventDefault();
            //     Swal.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonColor: '#3085d6',
            //     cancelButtonColor: '#d33',
            //     confirmButtonText: 'Yes'
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         $('#form-order').submit();
            //     }
            // })
            // })



        })
    </script>
@endsection
