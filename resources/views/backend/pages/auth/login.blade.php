<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login </title>
    <link href="{{ url('assets/backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/backend/img/undraw_rocket.svg') }}" />
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 900px;
            background: #ffffffdd;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .left {
            flex: 1;
            background: url('{{ url('assets/backend/img/login.jpg') }}') center/cover no-repeat;
            min-height: 450px;
        }

        .right {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4e73df;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            background: #4e73df;
            color: white;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #3751c5;
        }

        .links {
            text-align: center;
            margin-top: 15px;
        }

        .links a {
            color: #4e73df;
            text-decoration: none;
            font-size: 14px;
        }

        .alert {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
        }

        .alert-danger {
            background: #f8d7da;
        }

        .text-danger {
            color: #e74a3b;
            font-size: 13px;
        }

        .toast-message {
            position: fixed;
            top: 20px;
            right: -350px;
            /* hidden initially */
            padding: 15px 20px;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            transition: all 0.5s ease-in-out;
            opacity: 0;
        }

        .toast-message.success {
            background: linear-gradient(135deg, #28a745, #55c76a);
        }

        .toast-message.error {
            background: linear-gradient(135deg, #dc3545, #f77886);
        }

        .toast-show {
            right: 20px !important;
            opacity: 1;
        }
    </style>
</head>

<body>
    @if (session('success'))
        <div id="toast" class="toast-message success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="toast" class="toast-message error">
            {{ session('error') }}
        </div>
    @endif

    <div class="container">
        <div class="left"></div>

        <div class="right">
            <h2>Welcome Back</h2>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email Address">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label><input type="checkbox"> Remember Me</label>
                </div>

                <button type="submit" class="btn-login">Login</button>
            </form>

            <div class="links">
                <a href="forgot-password.html">Forgot Password?</a><br>

            </div>
        </div>
    </div>

</body>

</html>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toast = document.getElementById("toast");
        if (toast) {
            setTimeout(() => {
                toast.classList.add("toast-show");
            }, 100); // slight delay for animation

            // Hide after 3 seconds
            setTimeout(() => {
                toast.classList.remove("toast-show");
            }, 3000);
        }
    });
</script>
