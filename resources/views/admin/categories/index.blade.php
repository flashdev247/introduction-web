@extends('layouts.admin')
@section('content')
<h1>Categories</h1><p><a class="btn" href="{{ route('admin.categories.create') }}">Add category</a></p>
<table><thead><tr><th>Name</th><th>Slug</th><th>Products</th><th>Active</th><th></th></tr></thead><tbody>
@foreach($categories as $category)
<tr><td>{{ $category->name }}</td><td>{{ $category->slug }}</td><td>{{ $category->products_count }}</td><td>{{ $category->is_active ? 'Yes' : 'No' }}</td><td><a href="{{ route('admin.categories.edit',$category) }}">Edit</a><form method="post" action="{{ route('admin.categories.destroy',$category) }}" style="display:inline">@csrf @method('DELETE') <button onclick="return confirm('Delete?')">Delete</button></form></td></tr>
@endforeach
</tbody></table>
@endsection
