<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f6f6f3;margin:0;color:#222}.wrap{display:flex;min-height:100vh}.side{width:240px;background:#111;color:#fff;padding:24px}.side a{display:block;color:#fff;text-decoration:none;margin:12px 0}.main{flex:1;padding:32px}.card{background:#fff;border:1px solid #ddd;padding:24px;margin-bottom:20px}.btn{display:inline-block;background:#111;color:#fff;padding:9px 14px;text-decoration:none;border:0;cursor:pointer}.btn-light{background:#eee;color:#111}input,textarea,select{width:100%;padding:10px;border:1px solid #ccc;margin:6px 0 14px}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}table{width:100%;border-collapse:collapse;background:#fff}th,td{border-bottom:1px solid #ddd;padding:12px;text-align:left}.ok{background:#e7f7e7;padding:10px;margin-bottom:15px}
    </style>
</head>
<body>
<div class="wrap">
    <aside class="side">
        <h2>Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.products.index') }}">Products</a>
        <a href="{{ route('admin.categories.index') }}">Categories</a>
        <a href="{{ route('admin.settings.edit') }}">Contact Settings</a>
        <a href="{{ route('home') }}">View site</a>
        <form method="post" action="{{ route('admin.logout') }}" style="margin-top:20px">
            @csrf
            <button class="btn btn-light" type="submit">Logout</button>
        </form>
    </aside>
    <main class="main">
        @if(session('success'))<div class="ok">{{ session('success') }}</div>@endif
        @yield('content')
    </main>
</div>
</body>
</html>
