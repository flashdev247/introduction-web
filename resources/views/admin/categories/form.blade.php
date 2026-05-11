@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1>
        <i class="fas fa-folder-open"></i>
        {{ $category->exists ? 'Sửa danh mục' : 'Thêm danh mục mới' }}
    </h1>
</div>

<div class="card">
    <form method="post" action="{{ $category->exists ? route('admin.categories.update',$category) : route('admin.categories.store') }}">
        @csrf
        @if($category->exists)
        @method('PUT')
        @endif

        <div class="form-group">
            <label>Tên danh mục *</label>
            <input
                type="text"
                name="name"
                value="{{ old('name',$category->name) }}"
                placeholder="Nhập tên danh mục"
                required>
            @error('name')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <!-- slug removed -->

        <div class="form-group">
            <label>Ảnh (URL/đường dẫn)</label>
            <input
                type="text"
                name="image"
                value="{{ old('image',$category->image) }}"
                placeholder="https://example.com/image.jpg">
            @error('image')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" placeholder="Mô tả danh mục">{{ old('description',$category->description) }}</textarea>
            @error('description')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input
                    type="checkbox"
                    name="is_active"
                    id="is_active"
                    value="1"
                    @checked(old('is_active',$category->exists ? $category->is_active : true))
                >
                <label for="is_active">Đang hoạt động</label>
            </div>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i>
                {{ $category->exists ? 'Cập nhật danh mục' : 'Tạo danh mục' }}
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
                <i class="fas fa-times"></i>
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection
