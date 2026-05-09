@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-cog"></i> Settings</h1>
</div>

<div class="card">
    <form method="post" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Site Name *</label>
            <input
                type="text"
                name="site_name"
                value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                placeholder="Enter site name"
                required>
            @error('site_name')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Logo (URL/Path)</label>
            <input
                type="text"
                name="logo"
                value="{{ old('logo', $settings['logo'] ?? '') }}"
                placeholder="https://example.com/logo.png">
            @error('logo')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $settings['email'] ?? '') }}"
                placeholder="contact@example.com">
            @error('email')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone', $settings['phone'] ?? '') }}"
                placeholder="0123456789">
            @error('phone')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Zalo</label>
            <input
                type="text"
                name="zalo"
                value="{{ old('zalo', $settings['zalo'] ?? '') }}"
                placeholder="0987654321 or https://zalo.me/0987654321">
            <small style="color: #718096; font-size: 12px;">Example: 0987654321 or https://zalo.me/0987654321</small>
            @error('zalo')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Hotline</label>
            <input
                type="text"
                name="hotline"
                value="{{ old('hotline', $settings['hotline'] ?? '') }}"
                placeholder="0901234567">
            @error('hotline')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Address</label>
            <input
                type="text"
                name="address"
                value="{{ old('address', $settings['address'] ?? '') }}"
                placeholder="123 Main St, City, Country">
            @error('address')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Contact Information</label>
            <textarea
                name="contact_info"
                rows="6"
                placeholder="Additional contact information...">{{ old('contact_info', $settings['contact_info'] ?? '') }}</textarea>
            @error('contact_info')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i>
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
