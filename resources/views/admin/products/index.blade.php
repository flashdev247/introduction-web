@extends('layouts.admin')
@section('header_title', 'Sản phẩm')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-box"></i> Sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="btn">
        <i class="fas fa-plus"></i>
        Thêm sản phẩm mới
    </a>
</div>

<form method="get" action="{{ route('admin.products.index') }}" class="card order-filter-form">
    <div class="order-filter-field">
        <label for="product-search">Tên hoặc mô tả</label>
        <input id="product-search" type="text" name="q" value="{{ $search ?? request('q') }}" placeholder="Tìm kiếm sản phẩm...">
    </div>
    <div class="order-filter-actions">
        <button type="submit" class="btn">
            <i class="fas fa-search"></i> Tìm kiếm
        </button>
        @if(request('q'))
        <a class="btn btn-light" href="{{ route('admin.products.index') }}">Xóa lọc</a>
        @endif
    </div>
</form>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Danh mục</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td><strong>{{ $product->name }}</strong></td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td><strong>{{ $product->formatted_price }}</strong></td>
                <td>
                    @if($product->is_active)
                    <span style="background: #c6f6d5; color: #22543d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                        <i class="fas fa-check"></i> Đang hoạt động
                    </span>
                    @else
                    <span style="background: #fed7d7; color: #742a2a; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                        <i class="fas fa-times"></i> Hết hàng
                    </span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form method="post" action="{{ route('admin.products.destroy',$product) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" data-confirm-message="Xóa sản phẩm này?">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 48px; color: #a0aec0;">
                    <i class="fas fa-box-open" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                    Không có sản phẩm nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($products->hasPages())
<div class="pagination-wrapper">
    {{ $products->links() }}
</div>
@endif
@endsection
