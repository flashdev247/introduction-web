@extends('layouts.admin')
@section('content')
<h1>{{ $product->exists ? 'Edit' : 'Add' }} Product</h1>
<form method="post" action="{{ $product->exists ? route('admin.products.update',$product) : route('admin.products.store') }}">
@csrf @if($product->exists) @method('PUT') @endif
<label>Name</label><input name="name" value="{{ old('name',$product->name) }}" required>
<label>Slug</label><input name="slug" value="{{ old('slug',$product->slug) }}">
<label>Category</label><select name="category_id"><option value="">-- None --</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select>
<label>SKU</label><input name="sku" value="{{ old('sku',$product->sku) }}">
<label>Price</label><input name="price" type="number" step="0.01" value="{{ old('price',$product->price) }}">
<label>Short description</label><textarea name="short_description">{{ old('short_description',$product->short_description) }}</textarea>
<label>Description</label><textarea name="description" rows="6">{{ old('description',$product->description) }}</textarea>
<label>Images (one URL/path per line)</label><textarea name="images_text" rows="5">{{ old('images_text', implode("\n", $product->images ?? [])) }}</textarea>
<label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured',$product->is_featured)) style="width:auto"> Featured</label>
<label><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$product->exists ? $product->is_active : true)) style="width:auto"> Active</label>
<button class="btn">Save</button> <a class="btn btn-light" href="{{ route('admin.products.index') }}">Cancel</a>
</form>
@endsection
