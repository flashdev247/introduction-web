@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', ($settings->site_name ?? 'ULIHU') . ' — Home')

@section('content')
<section class="hero-section">
    <div class="container hero-content">
        <div class="hero-text">
            <h1>Explore Our<br />Packages</h1>
            <p>Discover our premium selection of packages designed to meet your needs.</p>
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/home/hero-banner.png') }}" alt="Lamp with flower">
        </div>
    </div>
</section>

@if($featuredProducts && $featuredProducts->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-head">
            <h2 class="section-title">Featured Products</h2>
            <a href="{{ route('products.index') }}" class="btn btn-outline">View All</a>
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
