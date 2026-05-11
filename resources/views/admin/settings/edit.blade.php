@extends('layouts.admin')
@section('content')
<div class="page-header">
    <h1><i class="fas fa-cog"></i> Cài đặt</h1>
</div>

<div class="card">
    <form method="post" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Tên website *</label>
            <input
                type="text"
                name="site_name"
                value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                placeholder="Nhập tên website"
                required>
            @error('site_name')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Địa chỉ email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $settings['email'] ?? '') }}"
                placeholder="contact@example.com">
            @error('email')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Điện thoại</label>
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
                placeholder="0987654321 hoặc https://zalo.me/0987654321">
            <small style="color: #718096; font-size: 12px;">Ví dụ: 0987654321 hoặc https://zalo.me/0987654321</small>
            @error('zalo')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Shopee</label>
            <input
                type="text"
                name="shopee"
                value="{{ old('shopee', $settings['shopee'] ?? '') }}"
                placeholder="https://shopee.vn/...">
            <small style="color: #718096; font-size: 12px;">Dán link shop Shopee của bạn vào đây.</small>
            @error('shopee')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <!-- Hotline removed: phone is used as primary contact -->

        <div class="form-group">
            <label>Địa chỉ</label>
            <input
                type="text"
                name="address"
                value="{{ old('address', $settings['address'] ?? '') }}"
                placeholder="123 Đường chính, Thành phố, Quốc gia">
            @error('address')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label>Thông tin liên hệ</label>
            <textarea
                name="contact_info"
                rows="6"
                placeholder="Thông tin liên hệ bổ sung...">{{ old('contact_info', $settings['contact_info'] ?? '') }}</textarea>
            @error('contact_info')<span style="color: #e53e3e; font-size: 13px;">{{ $message }}</span>@enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 32px;">
            <button type="submit" class="btn">
                <i class="fas fa-save"></i>
                Lưu cài đặt
            </button>
        </div>
    </form>
</div>
@endsection
