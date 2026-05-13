@extends('layouts.front', ['settings' => $settings ?? null])

@section('title', $product->name . ' — ' . ($settings->site_name ?? 'HTTM VIETNAM'))

@section('content')
<section class="section">
    <div class="container detail">
        <div class="gallery">
            @php $images = $product->images ?? []; @endphp
            @if(count($images) > 0)
            <div style="position:relative">
                <img id="galleryMain" class="gallery__main" src="{{ $images[0] }}" alt="{{ $product->name }}">
                @if(count($images) > 1)
                <button type="button" class="gallery__nav gallery__nav--prev" onclick="galleryNav(-1)">&#8592;</button>
                <button type="button" class="gallery__nav gallery__nav--next" onclick="galleryNav(1)">&#8594;</button>
                @endif
            </div>
            @if(count($images) > 1)
            <div class="gallery__thumbs">
                @foreach($images as $i => $img)
                <img class="gallery__thumb {{ $i === 0 ? 'active' : '' }}" src="{{ $img }}" alt="{{ $product->name }}" onclick="gallerySelect({{ $i }})">
                @endforeach
            </div>
            @endif
            @else
            <div class="gallery__main" style="display:grid;place-items:center;min-height:400px;color:var(--muted)">Chưa có ảnh</div>
            @endif
        </div>

        <div>
            @if($product->category)
            <p class="product-card__category">{{ $product->category->name }}</p>
            @endif
            <h1>{{ $product->name }}</h1>
            @if($product->formatted_price)
            <p class="detail-price">{{ $product->formatted_price }}</p>
            @endif
            @if($product->description)
            <div class="content" style="margin-top:18px; color: #2d3748; line-height:1.7;">
                {!! $product->description !!}
            </div>
            @endif
            <div style="margin-top:20px; display:flex; align-items:center; gap:10px; flex-wrap:wrap;" data-product-purchase
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                data-product-price="{{ (int) round((float) $product->price) }}"
                data-product-image="{{ $product->first_image }}">
                <button type="button" class="btn btn-outline" data-qty-minus>-</button>
                <input type="number" min="1" value="1" style="max-width:90px; text-align:center;" data-qty-input>
                <button type="button" class="btn btn-outline" data-qty-plus>+</button>
                <button type="button" class="btn" data-add-to-cart>Thêm vào giỏ hàng</button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function() {
        const images = @json($images ?? []);
        let current = 0;
        const mainImg = document.getElementById('galleryMain');
        const thumbs = document.querySelectorAll('.gallery__thumb');

        window.gallerySelect = function(i) {
            if (i < 0 || i >= images.length) return;
            current = i;
            mainImg.src = images[i];
            thumbs.forEach((t, idx) => t.classList.toggle('active', idx === i));
        };

        window.galleryNav = function(dir) {
            let next = current + dir;
            if (next < 0) next = images.length - 1;
            if (next >= images.length) next = 0;
            gallerySelect(next);
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') galleryNav(-1);
            if (e.key === 'ArrowRight') galleryNav(1);
        });
    })();
</script>
@endpush
