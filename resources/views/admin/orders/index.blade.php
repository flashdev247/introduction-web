@extends('layouts.admin')
@section('header_title', 'Đơn hàng')
@section('content')
@php
    $statusLabels = [
        'new' => 'Mới',
        'processing' => 'Đang xử lý',
        'completed' => 'Hoàn tất',
        'cancelled' => 'Đã hủy',
    ];
@endphp

<div class="page-header">
    <h1><i class="fas fa-receipt"></i> Đơn hàng</h1>
</div>

<form method="get" action="{{ route('admin.orders.index') }}" class="card order-filter-form">
    <div class="order-filter-field">
        <label for="order-status">Trạng thái</label>
        <select id="order-status" name="status">
            <option value="">Tất cả</option>
            @foreach($statusLabels as $value => $label)
            <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="order-filter-field">
        <label for="order-from-date">Từ ngày</label>
        <input id="order-from-date" type="date" name="from_date" value="{{ $filters['from_date'] ?? '' }}">
    </div>
    <div class="order-filter-field">
        <label for="order-to-date">Đến ngày</label>
        <input id="order-to-date" type="date" name="to_date" value="{{ $filters['to_date'] ?? '' }}">
    </div>
    <div class="order-filter-actions">
        <button type="submit" class="btn">
            <i class="fas fa-search"></i> Tìm kiếm
        </button>
        @if(($filters['status'] ?? null) || ($filters['from_date'] ?? null) || ($filters['to_date'] ?? null))
        <a class="btn btn-light" href="{{ route('admin.orders.index') }}">Xóa lọc</a>
        @endif
    </div>
</form>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Khách hàng</th>
                <th>SĐT</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td><strong>{{ $order->code }}</strong></td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_phone }}</td>
                <td>{{ $order->items_count }}</td>
                <td><strong>{{ number_format($order->total, 0, ',', '.') }} đ</strong></td>
                <td>{{ $statusLabels[$order->status] ?? '-' }}</td>
                <td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">
                        <i class="fas fa-eye"></i> Chi tiết
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:32px;">Chưa có đơn hàng nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($orders->hasPages())
<div class="pagination-wrapper">
    {{ $orders->links() }}
</div>
@endif

<style>
    .order-filter-form {
        display: grid;
        grid-template-columns: minmax(180px, 1.1fr) repeat(2, minmax(160px, 1fr)) auto;
        align-items: end;
        gap: 16px;
    }

    .order-filter-field label {
        margin-bottom: 6px;
    }

    .order-filter-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .order-filter-actions .btn {
        min-height: 45px;
        white-space: nowrap;
    }

    @media (max-width: 1024px) {
        .order-filter-form {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 640px) {
        .order-filter-form {
            grid-template-columns: 1fr;
        }

        .order-filter-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection
