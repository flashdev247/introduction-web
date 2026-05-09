@extends('layouts.admin')
@section('content')
<h1>Contact Settings</h1>
<form method="post" action="{{ route('admin.settings.update') }}">
@csrf @method('PUT')
<label>Site name</label><input name="site_name" value="{{ old('site_name',$setting->site_name) }}" required>
<label>Logo path/URL</label><input name="logo" value="{{ old('logo',$setting->logo) }}">
<label>Email</label><input name="email" value="{{ old('email',$setting->email) }}">
<label>Phone</label><input name="phone" value="{{ old('phone',$setting->phone) }}">
<label>Zalo</label><input name="zalo" value="{{ old('zalo',$setting->zalo) }}" placeholder="VD: 0987654321 hoặc https://zalo.me/0987654321">
<label>Hotline</label><input name="hotline" value="{{ old('hotline',$setting->hotline) }}" placeholder="VD: 0901234567">
<label>Address</label><input name="address" value="{{ old('address',$setting->address) }}">
<label>Contact info</label><textarea name="contact_info" rows="5">{{ old('contact_info',$setting->contact_info) }}</textarea>
<button class="btn">Save settings</button>
</form>
@endsection
