@extends('layouts.front', ['settings' => $settings ?? null])
@section('title', 'Giỏ hàng - ' . ($settings->site_name ?? 'HTTM VIETNAM'))

@section('content')
<style>
    .cart-page {
        padding-top: 52px;
    }

    .cart-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.36fr) minmax(300px, .64fr);
        gap: 28px;
        align-items: start;
    }

    .cart-panel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 22px;
    }

    .cart-title {
        margin: 0 0 8px;
        font-size: 34px;
        line-height: 1.15;
        font-weight: 700;
        letter-spacing: 0;
    }

    .cart-items {
        display: grid;
        gap: 12px;
        margin-top: 18px;
    }

    .cart-field {
        margin-top: 22px;
    }

    .cart-field label {
        font-size: 15px;
        margin-bottom: 8px;
    }

    .cart-note {
        min-height: 124px;
        border-color: var(--line);
        border-radius: 6px;
    }

    .invoice-toggle {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr);
        align-items: center;
        gap: 10px;
        width: 100%;
        margin: 0;
        font-size: 15px;
        font-weight: 700;
    }

    .invoice-toggle input {
        flex: 0 0 auto;
    }

    .invoice-toggle span {
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .invoice-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 14px;
    }

    .invoice-grid input {
        border-color: var(--line);
        border-radius: 4px;
    }

    .order-summary {
        position: sticky;
        top: 110px;
    }

    .order-summary h2 {
        margin: 0 0 14px;
        font-size: 21px;
        line-height: 1.25;
        font-weight: 700;
    }

    .order-total-label {
        color: var(--muted);
        font-size: 14px;
        margin: 0;
    }

    .order-total {
        margin: 4px 0 16px;
        color: var(--accent);
        font-size: 30px;
        line-height: 1.1;
        font-weight: 700;
    }

    .order-policy {
        margin: 0 0 18px;
        padding: 12px 14px;
        border: 1px solid #eadfce;
        border-radius: 6px;
        background: #fbf8f3;
        color: #5f5549;
        font-size: 14px;
    }

    .checkout-btn {
        width: 100%;
        min-height: 46px;
        border-radius: 4px;
        background: var(--accent) !important;
        border-color: var(--accent) !important;
        color: #fff;
        font-weight: 700;
        letter-spacing: .04em;
    }

    .checkout-btn:hover {
        filter: brightness(.95);
    }

    .invoice-modal-card {
        max-width: 500px;
        background: #fff;
        margin: 10vh auto 0;
        padding: 30px;
        text-align: center;
        border: 1px solid var(--line);
        border-radius: 8px;
    }

    .invoice-modal-icon {
        width: 74px;
        height: 74px;
        border: 4px solid #f4bf8c;
        border-radius: 50%;
        display: grid;
        place-items: center;
        margin: 0 auto 16px;
        color: #f4a261;
        font-size: 40px;
        line-height: 1;
    }

    .invoice-modal-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        margin-top: 22px;
    }

    .invoice-modal-actions .btn {
        min-width: 112px;
        border-radius: 4px;
    }

    @media (max-width: 980px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }

        .order-summary {
            position: static;
        }
    }

    @media (max-width: 640px) {
        .cart-page {
            padding-top: 36px;
        }

        .cart-panel {
            padding: 18px;
        }

        .cart-title {
            font-size: 30px;
        }

        .invoice-grid {
            grid-template-columns: 1fr;
        }

        .invoice-toggle span {
            font-size: 14px;
        }
    }
</style>

<section class="section cart-page" data-cart-page>
    <div class="container cart-layout">
        <div class="cart-panel">
            <h1 class="cart-title">Giỏ hàng của bạn</h1>
            <p class="muted" data-cart-summary>Bạn đang có 0 sản phẩm trong giỏ hàng</p>
            <div class="cart-items" data-cart-items></div>

            <div class="cart-field">
                <label for="order-note">Ghi chú đơn hàng</label>
                <textarea id="order-note" class="cart-note" data-order-note></textarea>
            </div>

            <div class="cart-field">
                <label class="invoice-toggle">
                    <input type="checkbox" data-invoice-toggle>
                    <span>Xuất hóa đơn cho đơn hàng</span>
                </label>
                <div data-invoice-form style="display:none;">
                    <div class="invoice-grid">
                        <input type="text" placeholder="Tên công ty..." data-invoice-company>
                        <input type="text" placeholder="Mã số thuế..." data-invoice-tax-code>
                        <input type="email" placeholder="Email..." data-invoice-email>
                        <input type="text" placeholder="Địa chỉ công ty..." data-invoice-address>
                    </div>
                </div>
            </div>
        </div>

        <aside class="order-summary">
            <div class="cart-panel">
                <h2>Thông tin đơn hàng</h2>
                <p class="order-total-label">Tổng tiền</p>
                <p class="order-total" data-cart-total>0đ</p>
                <p class="order-policy">Đơn hàng tối thiểu 500.000đ mới được thanh toán.</p>
                <button class="btn checkout-btn" data-cart-checkout>THANH TOÁN</button>
            </div>
        </aside>
    </div>
</section>

<div data-invoice-confirm-modal style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.35); z-index:60;">
    <div class="invoice-modal-card">
        <div class="invoice-modal-icon">!</div>
        <h3>BẠN CÓ MUỐN XUẤT HÓA ĐƠN?</h3>
        <p>Hãy kiểm tra lại thông tin hóa đơn của mình thật chính xác.</p>
        <div class="invoice-modal-actions">
            <button class="btn" style="background:#111;" data-invoice-confirm-no>KHÔNG</button>
            <button class="btn checkout-btn" data-invoice-confirm-yes>CÓ</button>
        </div>
    </div>
</div>
@endsection
