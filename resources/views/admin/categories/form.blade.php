@extends('layouts.admin')
@section('content')
<h1>{{ $category->exists ? 'Edit' : 'Add' }} Category</h1>
<form method="post" action="{{ $category->exists ? route('admin.categories.update',$category) : route('admin.categories.store') }}">
@csrf @if($category->exists) @method('PUT') @endif
<label>Name</label><input name="name" value="{{ old('name',$category->name) }}" required>
<label>Slug</label><input name="slug" value="{{ old('slug',$category->slug) }}">
<label>Image</label><input name="image" value="{{ old('image',$category->image) }}">
<label>Description</label><textarea name="description">{{ old('description',$category->description) }}</textarea>
<label><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$category->exists ? $category->is_active : true)) style="width:auto"> Active</label>
<button class="btn">Save</button> <a class="btn btn-light" href="{{ route('admin.categories.index') }}">Cancel</a>
</form>
@endsection
