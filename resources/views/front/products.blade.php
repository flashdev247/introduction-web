@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', 'Sản phẩm — ' . ($settings->site_name ?? 'HTTM VIETNAM'))

@section('content')
<section class="page-title">
    <div class="container">
        <h1>Sản phẩm</h1>
        <p class="muted">Xem bộ sưu tập mới nhất của chúng tôi.</p>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="container">
        @if(isset($categories) && $categories->count() > 0)
        <div class="filters">
            <a class="filter {{ request('category') ? '' : 'active' }}" href="{{ route('products.index') }}">Tất cả</a>
            @foreach($categories as $category)
            <a class="filter {{ request('category') == $category->id ? 'active' : '' }}" href="{{ route('products.index', ['category' => $category->id]) }}">
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
        <p class="muted">Không tìm thấy sản phẩm nào.</p>
        @endif
    </div>
</section>
@endsection
