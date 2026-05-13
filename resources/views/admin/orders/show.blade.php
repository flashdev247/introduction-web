@extends('layouts.admin')
@section('header_title', 'Chi tiết đơn hàng')
@section('content')
@php
    $statusLabels = [
        'new' => 'Mới',
        'processing' => 'Đang xử lý',
        'completed' => 'Hoàn tất',
        'cancelled' => 'Đã hủy',
    ];
@endphp

<style>
    .order-detail-page .card strong {
        font-size: inherit;
        color: inherit;
    }

    .order-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 24px;
    }

    .order-detail-field {
        min-width: 0;
    }

    .order-detail-field--full {
        grid-column: 1 / -1;
    }

    .order-detail-label {
        display: block;
        margin: 0 0 4px;
        color: #718096;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .order-detail-value {
        color: #1a202c;
        font-size: 15px;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    .order-detail-total {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid #e2e8f0;
    }

    .order-detail-total span {
        color: #718096;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .order-detail-total strong {
        color: #1a202c;
        font-size: 20px;
        font-weight: 700;
    }

    .order-detail-status-form {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .order-detail-page .table-wrapper td:nth-child(2),
    .order-detail-page .table-wrapper td:nth-child(4) {
        font-weight: 600;
        color: #1a202c;
    }

    @media (max-width: 768px) {
        .order-detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="order-detail-page">
    <div class="page-header">
        <h1><i class="fas fa-file-invoice"></i> {{ $order->code }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-light">Quay lại</a>
    </div>

    <div class="card">
        <h3>Thông tin khách hàng</h3>
        <div class="order-detail-grid">
            <div class="order-detail-field">
                <span class="order-detail-label">Họ tên</span>
                <div class="order-detail-value">{{ $order->customer_name }}</div>
            </div>
            <div class="order-detail-field">
                <span class="order-detail-label">SĐT</span>
                <div class="order-detail-value">{{ $order->customer_phone }}</div>
            </div>
            <div class="order-detail-field">
                <span class="order-detail-label">Email</span>
                <div class="order-detail-value">{{ $order->customer_email ?: '-' }}</div>
            </div>
            <div class="order-detail-field">
                <span class="order-detail-label">Trạng thái</span>
                <div class="order-detail-value">{{ $statusLabels[$order->status] ?? '-' }}</div>
            </div>
            <div class="order-detail-field order-detail-field--full">
                <span class="order-detail-label">Địa chỉ</span>
                <div class="order-detail-value">{{ $order->shipping_address_detail }}, {{ $order->commune_name }}, {{ $order->province_name }}</div>
            </div>
            <div class="order-detail-field order-detail-field--full">
                <span class="order-detail-label">Ghi chú</span>
                <div class="order-detail-value">{{ $order->note ?: '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h3>Trạng thái đơn hàng</h3>
        <form method="post" action="{{ route('admin.orders.update-status', $order) }}" class="order-detail-status-form">
            @csrf
            @method('PATCH')
            <select name="status" style="max-width:220px;">
                @foreach($statusLabels as $value => $label)
                <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn" type="submit">Cập nhật</button>
        </form>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>SL</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ number_format($item->product_price, 0, ',', '.') }} đ</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->line_total, 0, ',', '.') }} đ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Thông tin hóa đơn</h3>
        <div class="order-detail-grid">
            <div class="order-detail-field">
                <span class="order-detail-label">Xuất hóa đơn</span>
                <div class="order-detail-value">{{ $order->wants_invoice ? 'Có' : 'Không' }}</div>
            </div>
            @if($order->wants_invoice)
            <div class="order-detail-field">
                <span class="order-detail-label">Công ty</span>
                <div class="order-detail-value">{{ $order->invoice_company ?: '-' }}</div>
            </div>
            <div class="order-detail-field">
                <span class="order-detail-label">MST</span>
                <div class="order-detail-value">{{ $order->invoice_tax_code ?: '-' }}</div>
            </div>
            <div class="order-detail-field">
                <span class="order-detail-label">Email</span>
                <div class="order-detail-value">{{ $order->invoice_email ?: '-' }}</div>
            </div>
            <div class="order-detail-field order-detail-field--full">
                <span class="order-detail-label">Địa chỉ</span>
                <div class="order-detail-value">{{ $order->invoice_address ?: '-' }}</div>
            </div>
            @endif
        </div>
        <div class="order-detail-total">
            <span>Tổng tiền</span>
            <strong>{{ number_format($order->total, 0, ',', '.') }} đ</strong>
        </div>
    </div>
</div>
@endsection
