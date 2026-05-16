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
        <form method="get" action="{{ route('products.index') }}" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-bottom:16px;">
            @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <input
                type="text"
                name="q"
                value="{{ $search ?? request('q') }}"
                placeholder="Tìm kiếm sản phẩm..."
                style="max-width:360px; width:100%;"
            >
            <button type="submit" class="btn">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
            @if(request('q') || request('category'))
            <a class="btn btn-outline" href="{{ route('products.index') }}">Xóa lọc</a>
            @endif
        </form>

        @if(isset($categories) && $categories->count() > 0)
        <div class="filters">
            <a class="filter {{ request('category') ? '' : 'active' }}" href="{{ route('products.index', array_filter(['q' => request('q')])) }}">Tất cả</a>
            @foreach($categories as $category)
            <a class="filter {{ request('category') == $category->id ? 'active' : '' }}" href="{{ route('products.index', array_filter(['category' => $category->id, 'q' => request('q')])) }}">
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
