<article class="product-card">
    <a class="product-card__image" href="{{ route('products.show', $product->id) }}">
        @if($product->first_image)
        <img class="product-card__img product-card__img--primary" src="{{ $product->first_image }}" alt="{{ $product->name }}">
        @if($product->images && count($product->images) > 1)
        <img class="product-card__img product-card__img--hover" src="{{ $product->images[1] }}" alt="{{ $product->name }}">
        @endif
        @else
        <div class="product-card__placeholder">Chưa có ảnh</div>
        @endif
    </a>
    <div class="product-card__body">
        @if($product->category)
        <a class="product-card__category" href="{{ route('products.index', ['category' => $product->category->id]) }}">{{ $product->category->name }}</a>
        @endif
        <h3><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h3>
        @if($product->formatted_price)
        <p class="product-card__price">{{ $product->formatted_price }}</p>
        @endif
    </div>
</article>
