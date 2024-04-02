@extends('client.layout')




@section('content')
    <style>
      
      .center {
            border-radius: 8px;
            background: white;
            padding: 32px;
            margin: auto;
            float: none;
            position: relative;
            max-width: 640px;
            box-shadow: 0 2px 12px 1px rgba(0, 0, 0, .18);
        }

        .center .title {
            font-family: "Fira Sans", sans-serif;
            font-size: 1.5rem;
            line-height: 1.5rem;
            color: #0a0c0f;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }

        .center .input-group {
            padding: 10px 0;
        }

        .center .input-group span {
            color: #000;

        }

        .center .input-group input {
            width: 100%;
            padding: 8px;
        }

        .center .btn-register {
            width: 100%;
            background-color: #008DDA;
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 10px;
        }
        .center .signup_link{
            margin-top: 15px;
            justify-content: center;
            text-align: center;
        }
        .center .signup_link > a{
            color: #008DDA;
        }
        
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="center">
                    <div class="title">Đăng ký</div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                <span class="text-danger" style="margin-left: 30px">{{ session('error') ?? null }}</span>
                    <form method="post" action="{{ route('user.auth.register') }}">
                        @csrf
                        <div class="input-group">
                            <span>Họ và tên:</span>
                            <input type="text" required name="fullName">
                        </div>
                        <div class="input-group">
                            <span>Số điện thoại:</span>
                            <input type="number" required name="phoneNumber">
                        </div>
                        <div class="input-group">
                            <span>Email:</span>
                            <input type="email" required name="email">
                        </div>
                        <div class="input-group">
                            <span>Password:</span>
                            <input type="password" required name="password">
                        </div>
                      
                        <div class="input-group">
                            <span>Re-Password:</span>
                            <input type="password" required name="rePassword">
                        </div>
                      
                      
                    
                      
                        {{-- <div class="pass">Forgot Password?</div> --}}
                        
                        
                        <input class="btn-register" type="submit" value="Đăng ký">
                        <div class="signup_link">
                            Đăng nhập tại <a href="{{ route('user.login') }}">Đây</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
