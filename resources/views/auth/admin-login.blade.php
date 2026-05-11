<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập quản trị</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <style>
        body{font-family:Arial,sans-serif;background:#f6f6f3;margin:0;color:#222;min-height:100vh;display:grid;place-items:center}
        .card{width:min(420px,calc(100% - 32px));background:#fff;border:1px solid #ddd;padding:32px}
        h1{margin:0 0 24px}label{display:block;margin:0 0 14px;font-weight:700}input{width:100%;box-sizing:border-box;padding:11px;border:1px solid #ccc;margin-top:6px}
        .btn{display:inline-block;background:#111;color:#fff;padding:11px 16px;border:0;cursor:pointer}.err{background:#fff0f0;color:#b00020;padding:10px;margin-bottom:16px}.row{display:flex;align-items:center;gap:8px;margin-bottom:18px}.row input{width:auto;margin:0}
        a{color:#111}
    </style>
</head>
<body>
    <form class="card" method="post" action="{{ route('admin.login.submit') }}">
        @csrf
        <h1>Đăng nhập quản trị</h1>

        @if($errors->any())
            <div class="err">{{ $errors->first() }}</div>
        @endif

        <label>Email
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </label>

        <label>Mật khẩu
            <input type="password" name="password" required>
        </label>

        <label class="row">
            <input type="checkbox" name="remember" value="1">
            <span>Ghi nhớ đăng nhập</span>
        </label>

        <button class="btn" type="submit">Đăng nhập</button>
        <a href="{{ route('home') }}" style="margin-left:12px">Quay lại website</a>
    </form>
</body>
</html>