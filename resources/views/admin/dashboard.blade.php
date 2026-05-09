@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-chart-line"></i> Dashboard</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon products">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h4>Total Products</h4>
            <strong>{{ $productsCount }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon categories">
            <i class="fas fa-folder-open"></i>
        </div>
        <div class="stat-content">
            <h4>Total Categories</h4>
            <strong>{{ $categoriesCount }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon messages">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-content">
            <h4>Contact Messages</h4>
            <strong>{{ $messagesCount }}</strong>
        </div>
    </div>
</div>
@endsection
