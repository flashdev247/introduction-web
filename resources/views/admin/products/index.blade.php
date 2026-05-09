@extends('layouts.admin')
@section('header_title', 'Products')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-box"></i> Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn">
        <i class="fas fa-plus"></i>
        Add New Product
    </a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td><strong>{{ $product->name }}</strong></td>
                <td>{{ $product->category?->name ?? '-' }}</td>
                <td><strong>${{ number_format($product->price, 2) }}</strong></td>
                <td>
                    @if($product->is_active)
                    <span style="background: #c6f6d5; color: #22543d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                        <i class="fas fa-check"></i> Active
                    </span>
                    @else
                    <span style="background: #fed7d7; color: #742a2a; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                        <i class="fas fa-times"></i> Inactive
                    </span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form method="post" action="{{ route('admin.products.destroy',$product) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
