<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css') }}" rel="stylesheet">

    <style>
        /* Ensure the entire body takes up the full height */
        html, body {
            height: 100%;
            margin: 0;
        }

        /* Flexbox for centering */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100% - 60px); /* Adjust height to account for the footer */
            background-color: #f3f3f4; /* Optional: matches your gray-bg class */
        }

        .login-box {
            width: 100%;
            max-width: 400px; /* Limits the width for large screens */
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-box img {
            margin-bottom: 20px;
        }

        .form-group {
            position: relative;
        }

        .form-group .fa {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .form-group .fa-envelope, .form-group .fa-lock {
            color: #1AB394; /* Custom color for icons */
        }

        .form-control {
            padding-left: 35px;
        }

        .page-footer-inner {
            margin-top: 20px;
        }

        /* Adjustments for small screens */
        @media (max-width: 576px) {
            .login-box {
                padding: 10px;
            }
        }

        /* Flexbox layout for "Remember Me" and "Forgot Password" */
        .form-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .login-button .fa-sign-in {
            color: inherit; /* No specific color change for the login icon */
        }

        /* Fixed Footer styling */
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #fff;
            border-top: 1px solid #ddd;
            padding: 10px 20px;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #666;
        }

        .footer-content .footer-left {
            text-align: left;
        }

        .footer-content .footer-right {
            display: flex;
            gap: 15px; /* Space between links */
        }

        .footer-content .footer-right a {
            color: #1AB394;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .footer-content .footer-right a i {
            margin-right: 5px;
        }

        .footer-content .footer-right a:hover {
            text-decoration: underline;
        }

        /* Responsive design adjustments */
        @media (max-width: 576px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .footer-content .footer-left, .footer-content .footer-right {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body class="gray-bg">
    <div class="login-container">
        <div class="login-box text-center">
            <div>
    <img 
        src="{{ asset('../inspinia/img/gallery/logo.png') }}" 
        width="100px" 
        height="100px" 
        alt="Logo" 
        style="border-radius: 50%; object-fit: cover;" 
    />
</div>


            <!-- Email Field with Icon -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" class="form-control" name="email" placeholder="Enter Email Address" required>
                </div>

                <!-- Password Field with Icon -->
                <div class="form-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                </div>

                <!-- Remember Me and Forgot Password on the same row -->
                <div class="form-row">
                    <div class="checkbox i-checks">
                        <label>
                            <input type="checkbox" name="remember"> <i></i> Remember Me
                        </label>
                    </div>
                    <div>
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                </div>

                <!-- Login Button with Icon -->
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-sign-in"></i> Login
                </button>
            </form>
        </div>
    </div>

    <!-- Fixed Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-left">
                {{date('Y',time())}} © | <a href="https://techdevsystems.co.ke" target="_blank">Techdev Systems</a>
            </div>
            <div class="footer-right">
                <a href="#" target="_blank"><i class="fa fa-lock"></i> Privacy Policy</a>
                <a href="#" target="_blank"><i class="fa fa-file-text"></i> Terms of Use</a>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/bootstrap.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>

</html>
