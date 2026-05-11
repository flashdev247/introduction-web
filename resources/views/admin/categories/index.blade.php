@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-folder-open"></i> Danh mục</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn">
        <i class="fas fa-plus"></i>
        Thêm danh mục mới
    </a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Tên</th>
                <th>Sản phẩm</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td><strong>{{ $category->name }}</strong></td>
                <td>{{ $category->products_count }}</td>
                <td>
                    @if($category->is_active)
                    <span style="background: #c6f6d5; color: #22543d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                        <i class="fas fa-check"></i> Đang hoạt động
                    </span>
                    @else
                    <span style="background: #fed7d7; color: #742a2a; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                        <i class="fas fa-times"></i> Ngừng hoạt động
                    </span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.categories.edit',$category) }}" class="btn btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form method="post" action="{{ route('admin.categories.destroy',$category) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa danh mục này?')">
                                <i class="fas fa-trash"></i> Xóa
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
