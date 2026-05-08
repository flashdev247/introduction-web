@extends('layouts.admin')
@section('content')
<h1>Dashboard</h1>
<div class="grid">
    <div class="card"><h3>Products</h3><strong>{{ $productsCount }}</strong></div>
    <div class="card"><h3>Categories</h3><strong>{{ $categoriesCount }}</strong></div>
    <div class="card"><h3>Messages</h3><strong>{{ $messagesCount }}</strong></div>
</div>
@endsection
