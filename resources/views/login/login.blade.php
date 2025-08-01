@extends(getLayoutNameMultiReturnDefaultIfNull())

@section("title")
 Đăng nhập @endsection

@section('header')
@endsection

@section('css')
    @include("login.css")
@endsection

@section('js')

    <script src="https://www.google.com/recaptcha/api.js?render={{env("RECAPTCHA_SITE_KEY_2025")}}"></script>
    <script>
        window.addEventListener('load', function() {
            if(0) {
                const form = document.getElementById('formGlx');
                const submitButton = document.getElementById('submit_form');

                submitButton?.addEventListener('click', function (event) {
                    event.preventDefault();

                    grecaptcha.ready(function () {
                        grecaptcha.execute('6Lfnb8YUAAAAAElE9DwwEWA881UX3-chISAQZApu', {
                            action: 'submit_form'
                        }).then(function (token) {
                            document.getElementById('g-recaptcha-response').value = token;
                            form.submit();
                        }).catch(function (error) {
                            console.error('reCAPTCHA error:', error);
                        });
                    });
                });
            }
        });
    </script>

@endsection

@section("content")


    <style>

        a {
            text-decoration: none!important;
        }

        .auth_cont {
            text-align: center;
        }

        .auth_zone {
            text-align: left;
            display: inline-block;
            margin: 30px 10px;
            max-width: 600px;
            /*height: 320px;*/
            border: 1px solid #ccc;
            background-color: snow;
            border-radius: 5px;

            padding: 20px 30px;
        }
        .alert-danger {
            color: #721c24;
            background-color: transparent!important;
            border-color: transparent!important;
            color: red;
            font-style: italic;
            /* font-size: small; */
        }

        .alert {
            position: relative;
            padding: 3px 3px!important;;
            margin-bottom: 1rem!important;;
            margin-top: 1px!important;
            /* border-radius: 0.25rem; */
        }
        .content-wrapper {
            min-height: 600px;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white!important;
        }
        .auth_cont input {
             -webkit-appearance: auto!important;
        }
    </style>

<div class="auth_cont" data-code-pos="ppp1682131894047">
    <div class="auth_zone">
        @if($errors->any())
            <div class="jumbotron p-2 align-middle text-center mt-2 mb-2">
                @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <div class="" class="justify-content-center align-items-center">
            <div class="auth-column" class="col-md-6">
                <div class="auth-box" class="col-md-12">
                    <form id="formGlx" class="auth-form" class="form" action="{{route("post.login")}}" method="post">
                        @csrf

                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <div class="form-group text-center py-3">
                        <a href="{{ url('auth/google') }}" style=""
                           class="btn btn-warning">
                            <img style="width: 25px" src="/assert/Ionicons/src/social-googleplus.svg" alt="">
                            Đăng nhập nhanh với Gmail
                        </a>
                        </div>

                        <hr>

                        <h3 class="text-center ">Đăng nhập</h3>
                        <br>
                        <div class="form-group">
                            <label for="email" class="">Email hoặc Tài khoản:</label><br>
                            <input data-lpignore='true' required type="text" name="email" value="{{old('email')}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="">Mật khẩu:</label><br>
                            <input data-lpignore = 'true' required type="password" name="password" value="{{old('password')}}" class="form-control">
                        </div>
                        <div class="form-group text-center">

                            <div class="my-2">
                                <input name="remember_me" id="remember-me" type="checkbox"></span></label>
                            <label for="remember-me" class=""><span>Nhớ đăng nhập</span> <span>

                            </div>

                            <input id="submit_form" type="submit" class="btn btn-primary btn-sm" value="Đăng nhập">


                            <div class="py-3">
                                <a href="{{route("auth.register")}}" class="">Đăng ký</a>
                            |
                                <a href="{{route("auth.resetPassword")}}" class="">Quên mật khẩu</a>
                            |
                                <a href="{{route("auth.activeAccount")}}" class="">Kích hoạt tài khoản</a>
                                |
                                <a href="/" class="">Trang chủ</a>
                            </div>




                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
