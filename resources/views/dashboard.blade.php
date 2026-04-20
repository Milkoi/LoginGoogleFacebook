<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f5f5f5;
        }
        .card {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
        }
        img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin-bottom: 20px;
        }
        .info p {
            margin: 10px 0;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            background: crimson;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="card">
    <h1>Thông tin người dùng</h1>

    @if(auth()->user()->avatar)
        <img src="{{ auth()->user()->avatar }}" alt="Avatar">
    @endif

    <div class="info">
        <p><strong>Tên tài khoản:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p><strong>Provider:</strong> {{ auth()->user()->provider }}</p>

        <hr>

        <p><strong>Họ tên sinh viên:</strong>Lê Minh Quân</p>
        <p><strong>Mã sinh viên:</strong> 23810310115</p>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Đăng xuất</button>
    </form>
</div>
</body>
</html>