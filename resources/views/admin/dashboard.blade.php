@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-chart-line"></i> Bảng điều khiển</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon products">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h4>Tổng sản phẩm</h4>
            <strong>{{ $productsCount }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon categories">
            <i class="fas fa-folder-open"></i>
        </div>
        <div class="stat-content">
            <h4>Tổng danh mục</h4>
            <strong>{{ $categoriesCount }}</strong>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon messages">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-content">
            <h4>Tin nhắn liên hệ</h4>
            <strong>{{ $messagesCount }}</strong>
            @if($unreadMessagesCount > 0)
            <span style="color: #f56565; font-size: 14px; font-weight: 600; margin-left: 8px;">
                ({{ $unreadMessagesCount }} chưa đọc)
            </span>
            @endif
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon products">
            <i class="fas fa-receipt"></i>
        </div>
        <div class="stat-content">
            <h4>Tổng đơn hàng</h4>
            <strong>{{ $ordersCount }}</strong>
        </div>
    </div>
</div>
@endsection
