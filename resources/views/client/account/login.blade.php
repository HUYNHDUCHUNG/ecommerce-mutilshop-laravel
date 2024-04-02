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

        .center .btn-login {
            width: 100%;
            background-color: #008DDA;
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 10px;
        }

        .center .spacer {
            position: relative;
            padding: 20px 0;
            text-align: center
        }

        .center .spacer::before {
            position: absolute;
            background-color: #a2abb4;
            content: '';
            width: 40%;
            height: 2px;
            top: 50%;
            left: 0;
        }

        .center .spacer::after {
            position: absolute;
            background-color: #a2abb4;
            content: '';
            width: 40%;
            height: 2px;
            top: 50%;
            right: 0;
        }

        .center .btn-ghost {
            border: 1px solid #d1d6e0;
            border-radius: 32px;
            background: transparent;
            font-family: "Fira Sans", sans-serif;
            font-size: 1rem;
            line-height: 1.5rem;
            color: #0a0c0f;
            font-weight: 600;

            padding: 12px 12px;
            position: relative;
            transition: all 150ms ease-in-out;
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-bottom: 10px;
        }

        .center .btn-ghost img {
            width: 19px;
            margin-right: 5px;
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
                    <div class="title">Đăng nhập tài khoản của bạn</div>
                    <form method="post" action="{{ route('user.auth.login') }}">
                        @csrf
                        <div class="input-group">
                            <span>Email:</span>
                            <input type="text" required name="email">
                        </div>
                        <div class="input-group">
                            <span>Password:</span>
                            <input type="password" required name="password">
                        </div>
                        <span class="text-danger">{{ session('error') ?? null }}</span>
                        <input class="btn-login" type="submit" value="ĐĂNG NHẬP">
                        <div class="spacer">
                            Hoặc
                        </div>
                        <a href="" class="btn-ghost">
                            <img src="{{ asset('/client/img/logo-google.svg') }}" alt="Google">
                            ĐĂNG NHẬP BẰNG TÀI KHOẢN GOOGLE
                        </a>
                        <a href="" class="btn-ghost">
                            <img src="{{ asset('/client/img/logo-facebook.svg') }}" alt="facebook">
                            ĐĂNG NHẬP BẰNG TÀI KHOẢN FACEBOOK
                        </a>


                        <div class="signup_link">
                            Đăng ký tài khoản tại <a href="{{ route('user.register') }}">Đây</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
