@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', 'Contact — ' . ($settings->site_name ?? 'ULIHU'))

@section('content')
<section class="page-title">
    <div class="container">
        <h1>Contact</h1>
        <p class="muted">Get in touch with us.</p>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container contact-grid">
        <div class="info-card">
            <h3>Contact Information</h3>
            @if(!empty($settings?->contact_info))
                <p>{{ $settings->contact_info }}</p>
            @endif
            @if(!empty($settings?->email))
                <p><strong>Email:</strong> <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></p>
            @endif
            @if(!empty($settings?->phone))
                <p><strong>Phone:</strong> <a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></p>
            @endif
            @if(!empty($settings?->address))
                <p><strong>Address:</strong> {{ $settings->address }}</p>
            @endif
        </div>
        <div class="form-card">
            <h3>Send us a message</h3>
            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('contact') }}">
                @csrf
                <div class="form-row">
                    <div>
                        <label for="name">Name</label>
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
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
                    @error('subject')<small style="color:red">{{ $message }}</small>@enderror
                </div>
                <div>
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                    @error('message')<small style="color:red">{{ $message }}</small>@enderror
                </div>
                <button type="submit" class="btn" style="margin-top:16px">Send Message</button>
            </form>
        </div>
    </div>
</section>
@endsection
