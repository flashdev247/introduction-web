@extends('layouts.admin')
@section('content')
<h1>Products</h1><p><a class="btn" href="{{ route('admin.products.create') }}">Add product</a></p>
<table><thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Active</th><th></th></tr></thead><tbody>
@foreach($products as $product)
<tr><td>{{ $product->name }}</td><td>{{ $product->category?->name }}</td><td>{{ $product->formatted_price }}</td><td>{{ $product->is_active ? 'Yes' : 'No' }}</td><td><a href="{{ route('admin.products.edit',$product) }}">Edit</a><form method="post" action="{{ route('admin.products.destroy',$product) }}" style="display:inline">@csrf @method('DELETE') <button onclick="return confirm('Delete?')">Delete</button></form></td></tr>
@endforeach
</tbody></table>
@endsection
