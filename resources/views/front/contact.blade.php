@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', 'Liên hệ — ' . ($settings->site_name ?? 'HTTM VIETNAM'))

@section('content')
<section class="page-title">
    <div class="container">
        <h1>Liên hệ</h1>
        <p class="muted">Hãy liên hệ với chúng tôi.</p>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container contact-grid">
        <div class="info-card">
            <h3>Thông tin liên hệ</h3>
            @if(!empty($settings?->contact_info))
                <p>{{ $settings->contact_info }}</p>
            @endif
            @if(!empty($settings?->email))
                <p><strong>Email:</strong> <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></p>
            @endif
            @if(!empty($settings?->phone))
                <p><strong>Điện thoại:</strong> <a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></p>
            @endif
            @if(!empty($settings?->address))
                <p><strong>Địa chỉ:</strong> {{ $settings->address }}</p>
            @endif
        </div>
        <div class="form-card">
            <h3>Gửi tin nhắn cho chúng tôi</h3>
            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('contact') }}">
                @csrf
                <div class="form-row">
                    <div>
                        <label for="name">Họ tên</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<small style="color:red">{{ $message }}</small>@enderror
                    </div>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<small style="color:red">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div>
                    <label for="subject">Tiêu đề</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')<small style="color:red">{{ $message }}</small>@enderror
                </div>
                <div>
                    <label for="message">Nội dung</label>
                    <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                    @error('message')<small style="color:red">{{ $message }}</small>@enderror
                </div>
                <button type="submit" class="btn" style="margin-top:16px">Gửi tin nhắn</button>
            </form>
        </div>
    </div>
</section>
@endsection
