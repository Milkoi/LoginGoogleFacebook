<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Social</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .container { max-width: 500px; margin: auto; text-align: center; }
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            text-decoration: none;
            color: white;
            border-radius: 8px;
        }
        .google { background: #db4437; }
        .facebook { background: #1877f2; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 6px; }
        .success { background: #d1fae5; }
        .error { background: #fee2e2; }
    </style>
</head>
<body>
<div class="container">
    <h1>Đăng nhập hệ thống</h1>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <a class="btn google" href="{{ route('social.redirect', 'google') }}">
        Đăng nhập với Google
    </a>

    <a class="btn facebook" href="{{ route('social.redirect', 'facebook') }}">
        Đăng nhập với Facebook
    </a>
</div>
</body>
</html>