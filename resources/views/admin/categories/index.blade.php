@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-folder-open"></i> Categories</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn">
        <i class="fas fa-plus"></i>
        Add New Category
    </a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Products</th>
                <th>Active</th>
                <th>Actions</th>
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
                        <a href="{{ route('admin.categories.edit',$category) }}" class="btn btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form method="post" action="{{ route('admin.categories.destroy',$category) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">
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
