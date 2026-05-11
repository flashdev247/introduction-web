@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', ($settings->site_name ?? 'HTTM VIETNAM') . ' — Trang chủ')

@section('content')
<section class="hero-section">
    <div class="container hero-content">
        <div class="hero-text">
            <h1>Khám phá<br />bộ sưu tập của chúng tôi</h1>
            <p>Khám phá các sản phẩm nổi bật được tuyển chọn để phù hợp với nhu cầu của bạn.</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Sản phẩm trưng bày">
        </div>
    </div>
</section>

@if($featuredProducts && $featuredProducts->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">Sản phẩm nổi bật</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline">Xem tất cả</a>
        </div>
        <div class="grid">
            @foreach($featuredProducts as $product)
            @include('components.front.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
