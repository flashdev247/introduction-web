<!doctype html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $settings->site_name ?? 'HTTM VIETNAM')</title>
    <meta name="description" content="@yield('description', $settings->contact_info ?? '')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <style>
        :root {
            --bg: #ffffff;
            --text: #1f1f1f;
            --muted: #777;
            --line: #e6e0d6;
            --dark: #111;
            --accent: #8b6f47
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6
        }

        a {
            color: inherit;
            text-decoration: none
        }

        img {
            max-width: 100%;
            display: block
        }

        .container {
            width: min(1180px, calc(100% - 40px));
            margin: auto
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 20;
            background: linear-gradient(to bottom, #c9b49e, #ffffff);
            backdrop-filter: blur(10px);
        }

        .nav {
            height: 92px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            position: relative
        }

        .brand {
            font-weight: 800;
            letter-spacing: .18em;
            font-size: 22px;
            flex: 1
        }

        .brand img {
            max-height: 42px
        }

        .nav-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 700;
            color: #222
        }

        .nav-end {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-left: auto
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 32px
        }

        .menu a {
            font-size: 15px;
            font-weight: 500;
            color: #333
        }

        .menu a.active,
        .menu a:hover {
            color: #8b6f47
        }

        .social-icons {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            color: #666;
            transition: color .2s
        }

        .social-icons a:hover {
            color: #333
        }

        .social-icons svg {
            width: 20px;
            height: 20px;
            fill: currentColor
        }
        .social-icons img {
            width: 20px;
            height: 20px;
            display: block;
        }

        .hero {
            min-height: 520px;
            display: grid;
            place-items: center;
            text-align: center;
            background: linear-gradient(rgba(0, 0, 0, .28), rgba(0, 0, 0, .28)), url('/assets/images/logo.png');
            background-size: cover;
            background-position: center;
            color: white
        }

        .hero-section {
            padding: 80px 0;
            background: #fefdfb
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center
        }

        .hero-text h1 {
            font-size: 48px;
            line-height: 1.2;
            margin: 0 0 32px;
            letter-spacing: 0
        }

        .hero-text p {
            font-size: 18px;
            color: var(--muted);
            margin: 0;
            line-height: 1.6
        }

        .hero-image {
            display: flex;
            justify-content: flex-end
        }

        .hero-image img {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
            max-height: 500px;
            object-fit: cover
        }

        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px
            }

            .hero-text h1 {
                font-size: 36px
            }

            .hero-image {
                justify-content: center
            }

            .hero-image img {
                max-height: 400px
            }
        }

        .hero h1 {
            font-size: clamp(42px, 8vw, 92px);
            line-height: 1;
            margin: 0 0 18px;
            letter-spacing: .08em
        }

        .hero p {
            font-size: 18px;
            max-width: 640px;
            margin: 0 auto 28px
        }

        .btn {
            display: inline-block;
            background: var(--dark);
            color: #fff;
            border: 1px solid var(--dark);
            padding: 12px 22px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-size: 13px;
            cursor: pointer
        }

        .btn-outline {
            background: transparent;
            color: var(--dark)
        }

        .section {
            padding: 72px 0
        }

        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px
        }

        .section-title {
            font-size: 34px;
            line-height: 1.15;
            margin: 0
        }

        .muted {
            color: var(--muted)
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px
        }

        .product-card {
            background: #fff;
            border: 1px solid var(--line)
        }

        .product-card__image {
            aspect-ratio: 1/1;
            background: #eee;
            display: block;
            overflow: hidden;
            position: relative
        }

        .product-card__img--primary,
        .product-card__img--hover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity .3s, transform .25s
        }

        .product-card__img--hover {
            position: absolute;
            inset: 0;
            opacity: 0
        }

        .product-card:hover .product-card__img--hover {
            opacity: 1;
            transform: scale(1.04)
        }

        .product-card:hover .product-card__img--primary {
            opacity: 0
        }

        .product-card__placeholder {
            height: 100%;
            display: grid;
            place-items: center;
            color: var(--muted)
        }

        .product-card__body {
            padding: 12px
        }

        .product-card__category {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--accent)
        }

        .product-card h3 {
            font-size: 14px;
            line-height: 1.3;
            margin: 6px 0
        }

        .product-card__price {
            font-weight: 700;
            margin: 0 0 8px
        }

        .product-card__desc {
            color: var(--muted);
            font-size: 14px;
            margin: 0
        }

        .page-title {
            padding: 64px 0 30px
        }

        .page-title h1 {
            font-size: 48px;
            margin: 0 0 10px
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 32px
        }

        .filter {
            border: 1px solid var(--line);
            padding: 8px 14px;
            background: #fff
        }

        .filter.active {
            background: var(--dark);
            color: #fff
        }

        .detail {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 54px;
            align-items: start
        }

        .gallery {
            display: grid;
            gap: 16px;
            position: relative
        }

        .gallery__main {
            width: 100%;
            background: #eee;
            cursor: pointer
        }

        .gallery__nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, .85);
            border: 1px solid var(--line);
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            cursor: pointer;
            font-size: 18px;
            z-index: 2
        }

        .gallery__nav--prev {
            left: 8px
        }

        .gallery__nav--next {
            right: 8px
        }

        .gallery__thumbs {
            display: flex;
            gap: 8px;
            overflow-x: auto
        }

        .gallery__thumb {
            width: 72px;
            height: 72px;
            object-fit: cover;
            cursor: pointer;
            opacity: .5;
            border: 2px solid transparent;
            transition: opacity .2s, border-color .2s
        }

        .gallery__thumb.active,
        .gallery__thumb:hover {
            opacity: 1;
            border-color: var(--dark)
        }

        .detail h1 {
            font-size: 42px;
            line-height: 1.12;
            margin: 0 0 12px
        }

        .detail-price {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 24px
        }

        .detail-meta {
            color: var(--muted);
            margin-bottom: 20px
        }

        .content {
            max-width: 760px
        }

        .contact-grid {
            display: grid;
            grid-template-columns: .85fr 1.15fr;
            gap: 50px
        }

        .info-card,
        .form-card {
            background: #fff;
            border: 1px solid var(--line);
            padding: 26px
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        label {
            display: block;
            margin: 0 0 12px;
            font-weight: 700
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--line);
            background: #fff;
            font: inherit
        }

        textarea {
            min-height: 150px
        }

        .alert {
            padding: 14px 16px;
            margin-bottom: 18px;
            border: 1px solid #b7dfbd;
            background: #eef9ef
        }

        .float-buttons {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 12px
        }

        .float-btn {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            box-shadow: 0 10px 24px rgba(0, 0, 0, .22);
            transition: transform .2s, box-shadow .2s;
            color: #fff;
            text-decoration: none;
            position: relative;
            overflow: hidden
        }

        .float-btn:before {
            content: "";
            position: absolute;
            inset: 4px;
            border: 1px solid rgba(255, 255, 255, .38);
            border-radius: 50%
        }

        .float-btn:hover {
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 14px 30px rgba(0, 0, 0, .28)
        }

        .float-btn svg {
            width: 30px;
            height: 30px;
            fill: currentColor;
            position: relative;
            z-index: 1
        }

        .float-btn--zalo {
            background: linear-gradient(135deg, #00a3ff, #0068ff)
        }

        .float-btn--hotline {
            background: linear-gradient(135deg, #ff6b6b, #e53935)
        }

        .float-btn--hotline {
            animation: phonePulse 1.6s infinite
        }

        @keyframes phonePulse {

            0%,
            100% {
                box-shadow: 0 10px 24px rgba(229, 57, 53, .28)
            }

            50% {
                box-shadow: 0 10px 24px rgba(229, 57, 53, .28), 0 0 0 10px rgba(229, 57, 53, .13)
            }
        }

        .site-footer {
            border-top: 1px solid var(--line);
            padding: 36px 0;
            color: var(--muted)
        }

        .footer-inner {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap
        }

        @media(max-width:850px) {
            .nav {
                height: auto;
                padding: 18px 0;
                align-items: flex-start
            }

            .menu {
                flex-wrap: wrap;
                justify-content: flex-end
            }

            .grid,
            .detail,
            .contact-grid {
                grid-template-columns: 1fr
            }

            .hero {
                min-height: 420px
            }

            .section {
                padding: 48px 0
            }

            .section-head {
                display: block
            }

            .form-row {
                grid-template-columns: 1fr
            }
        }
    </style>
</head>

<body>
    @php
    $phoneValue = $settings?->phone;
    $phoneHref = $phoneValue ? 'tel:' . preg_replace('/\s+/', '', $phoneValue) : null;
    $zaloHref = null;
        $shopeeHref = null;
    if (!empty($settings?->zalo)) {
        $zaloHref = str_starts_with($settings->zalo, 'http')
            ? $settings->zalo
            : 'https://zalo.me/' . preg_replace('/\D+/', '', $settings->zalo);
    }
        if (!empty($settings?->shopee)) {
            $shopeeHref = str_starts_with($settings->shopee, 'http')
                ? $settings->shopee
                : 'https://' . ltrim($settings->shopee, '/');
        }
    @endphp

    <header class="site-header">
        <div class="container nav">
            <nav class="menu" aria-label="Main navigation">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Sản phẩm</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Liên hệ</a>
            </nav>

            <div class="nav-center">
                {{ $settings->site_name ?? 'HTTM VIETNAM' }}
            </div>

            <div class="nav-end">
                <div class="social-icons">
                    @if($phoneHref)
                    <a href="{{ $phoneHref }}" title="Gọi điện" aria-label="Gọi điện">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2a1.5 1.5 0 0 1 1.53-.36c1.68.56 3.15.86 4.56.91.83.03 1.5.7 1.5 1.53V21.5c0 .83-.67 1.5-1.5 1.5C10.2 23 1 13.8 1 2.5 1 1.67 1.67 1 2.5 1h4.25c.83 0 1.5.67 1.53 1.5.05 1.41.35 2.88.91 4.56.18.53.04 1.12-.36 1.53l-2.21 2.2Z" />
                        </svg>
                    </a>
                    @endif
                    @if($zaloHref)
                    <a href="{{ $zaloHref }}" title="Nhắn Zalo" aria-label="Nhắn Zalo" @if(!str_starts_with($zaloHref, 'tel:')) target="_blank" rel="noopener" @endif>
                        <svg viewBox="0 0 64 64" aria-hidden="true">
                            <path d="M32 6C17.64 6 6 15.92 6 28.16c0 6.92 3.78 13.1 9.7 17.16l-2.12 9.04a2 2 0 0 0 2.9 2.22l10.02-5.4c1.78.34 3.62.52 5.5.52 14.36 0 26-9.92 26-22.16S46.36 6 32 6Zm-9.3 29.96h-8.02a1.72 1.72 0 0 1-1.24-2.9l5.24-5.58h-3.78a1.7 1.7 0 1 1 0-3.4h7.66a1.72 1.72 0 0 1 1.24 2.9l-5.24 5.58h4.14a1.7 1.7 0 1 1 0 3.4Zm10.42-.04a1.7 1.7 0 0 1-1.7-1.34 4.72 4.72 0 1 1 0-5.84 1.7 1.7 0 0 1 3.38.28v5.2a1.7 1.7 0 0 1-1.68 1.7Zm-3.94-3.14a1.54 1.54 0 1 0 0-3.08 1.54 1.54 0 0 0 0 3.08Zm11.18 3.18a1.7 1.7 0 0 1-1.7-1.7v-8.5a1.7 1.7 0 1 1 3.4 0v8.5a1.7 1.7 0 0 1-1.7 1.7Zm8.06.12a4.86 4.86 0 1 1 0-9.72 4.86 4.86 0 0 1 0 9.72Zm0-3.28a1.58 1.58 0 1 0 0-3.16 1.58 1.58 0 0 0 0 3.16Z" />
                        </svg>
                    </a>
                    @endif
                        @if($shopeeHref)
                        <a href="{{ $shopeeHref }}" title="Mở Shopee" aria-label="Mở Shopee" target="_blank" rel="noopener">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0 0 30 30">
                                <path id="Ð¡Ð»Ð¾Ð¹_1" d="M25.6,6.5c-0.3-0.3-0.7-0.5-1.1-0.5h-4.5c-0.5-2.3-2.5-4-4.9-4s-4.4,1.7-4.9,4H5.6c-0.4,0-0.8,0.2-1.1,0.5 C4.1,6.8,4,7.3,4,7.7l0.7,15.2C4.8,24.7,6.2,26,7.9,26h14.1c1.7,0,3.2-1.4,3.2-3.1L26,7.7C26,7.3,25.9,6.8,25.6,6.5z M15,4 c1.3,0,2.4,0.8,2.8,2h-5.6C12.6,4.9,13.7,4,15,4z M15,22c-2.5,0-4.2-1.8-4.2-1.8l1.1-1.8c0,0,2,1.5,3.2,1.5 c1.1,0,2.1-0.6,2.1-1.4c0-0.9-0.6-1.3-2.4-1.9c-1.5-0.6-3.5-1.3-3.5-3.4c0-1.9,1.7-3.3,3.9-3.3c2.5,0,3.8,1.4,3.8,1.4l-1,1.7 c0,0-1.5-1.1-2.8-1.1c-1.1,0-1.9,0.5-1.9,1.3c0,0.6,0.6,1,2.1,1.5c1.6,0.6,3.8,1.4,3.8,3.8C19.1,20.5,17.3,22,15,22z"></path>
                            </svg>
                        </a>
                        @endif
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <div>
                <strong>{{ $settings->site_name ?? 'HTTM VIETNAM' }}</strong>
                @if(!empty($settings?->contact_info))
                <div>{{ $settings->contact_info }}</div>
                @endif
            </div>
            <div>
                @if(!empty($settings?->email))<div>Email: <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a></div>@endif
                @if(!empty($settings?->phone))<div>Điện thoại: <a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a></div>@endif
                @if(!empty($settings?->address))<div>Địa chỉ: {{ $settings->address }}</div>@endif
            </div>
        </div>
    </footer>

    @php
    $zaloUrl = $zaloHref;
    @endphp

    @if($zaloUrl || $phoneHref)
    <div class="float-buttons" aria-label="Liên hệ nhanh">
        @if($zaloUrl)
        <a class="float-btn float-btn--zalo" href="{{ $zaloUrl }}" target="_blank" rel="noopener" aria-label="Chat Zalo" title="Chat Zalo">
            <svg viewBox="0 0 64 64" aria-hidden="true">
                <path d="M32 6C17.64 6 6 15.92 6 28.16c0 6.92 3.78 13.1 9.7 17.16l-2.12 9.04a2 2 0 0 0 2.9 2.22l10.02-5.4c1.78.34 3.62.52 5.5.52 14.36 0 26-9.92 26-22.16S46.36 6 32 6Zm-9.3 29.96h-8.02a1.72 1.72 0 0 1-1.24-2.9l5.24-5.58h-3.78a1.7 1.7 0 1 1 0-3.4h7.66a1.72 1.72 0 0 1 1.24 2.9l-5.24 5.58h4.14a1.7 1.7 0 1 1 0 3.4Zm10.42-.04a1.7 1.7 0 0 1-1.7-1.34 4.72 4.72 0 1 1 0-5.84 1.7 1.7 0 0 1 3.38.28v5.2a1.7 1.7 0 0 1-1.68 1.7Zm-3.94-3.14a1.54 1.54 0 1 0 0-3.08 1.54 1.54 0 0 0 0 3.08Zm11.18 3.18a1.7 1.7 0 0 1-1.7-1.7v-8.5a1.7 1.7 0 1 1 3.4 0v8.5a1.7 1.7 0 0 1-1.7 1.7Zm8.06.12a4.86 4.86 0 1 1 0-9.72 4.86 4.86 0 0 1 0 9.72Zm0-3.28a1.58 1.58 0 1 0 0-3.16 1.58 1.58 0 0 0 0 3.16Z" />
            </svg>
        </a>
        @endif
        @if($phoneHref)
        <a class="float-btn float-btn--hotline" href="{{ $phoneHref }}" aria-label="Gọi điện" title="Gọi điện">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2a1.5 1.5 0 0 1 1.53-.36c1.68.56 3.15.86 4.56.91.83.03 1.5.7 1.5 1.53V21.5c0 .83-.67 1.5-1.5 1.5C10.2 23 1 13.8 1 2.5 1 1.67 1.67 1 2.5 1h4.25c.83 0 1.5.67 1.53 1.5.05 1.41.35 2.88.91 4.56.18.53.04 1.12-.36 1.53l-2.21 2.2Z" />
            </svg>
        </a>
        @endif
    </div>
    @endif

    @stack('scripts')
</body>

</html>
