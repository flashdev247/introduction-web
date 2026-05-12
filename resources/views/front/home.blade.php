@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', ($settings->site_name ?? 'HTTM VIETNAM') . ' — Trang chủ')

@section('content')
<section class="hero-section">
    <div class="container hero-content">
        <div class="hero-text">
            <h1>Hơn 25 Năm Đồng Hành Cùng Gian Bếp Việt</h1>
            <p>Với hơn 25 năm kinh nghiệm trong lĩnh vực đồ gia dụng nhà hàng – nhà bếp, chúng tôi chuyên cung cấp các sản phẩm chất lượng như hàng phíp, hàng nhựa, vỉ dính, dao kéo và nhiều dụng cụ bếp khác, đáp ứng nhu cầu từ gia đình đến nhà hàng chuyên nghiệp.</p>
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