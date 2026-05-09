@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', ($settings->site_name ?? 'ULIHU') . ' — Home')

@section('content')
<section class="hero">
    <div>
        <h1>{{ $settings->site_name ?? 'ULIHU' }}</h1>
        <p>{{ $settings->site_description ?? 'Timeless elegance, crafted with care' }}</p>
        <a href="{{ route('products.index') }}" class="btn">Shop Now</a>
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