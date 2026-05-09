@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', 'Products — ' . ($settings->site_name ?? 'ULIHU'))

@section('content')
<section class="page-title">
    <div class="container">
        <h1>Products</h1>
        <p class="muted">Browse our latest collection.</p>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container">
        @if(isset($categories) && $categories->count() > 0)
            <div class="filters">
                <a class="filter {{ request('category') ? '' : 'active' }}" href="{{ route('products.index') }}">All</a>
                @foreach($categories as $category)
                    <a class="filter {{ request('category') === $category->slug ? 'active' : '' }}" href="{{ route('products.index', ['category' => $category->slug]) }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($products && $products->count() > 0)
            <div class="grid">
                @foreach($products as $product)
                    @include('components.front.product-card', ['product' => $product])
                @endforeach
            </div>

            @if(method_exists($products, 'links'))
                <div style="margin-top:32px">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <p class="muted">No products found.</p>
        @endif
    </div>
</section>
@endsection