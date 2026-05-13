@extends('layouts.front', ['settings' => $settings ?? null])
@section('title', 'Thanh toán - ' . ($settings->site_name ?? 'HTTM VIETNAM'))

@section('content')
<style>
    .checkout-page {
        padding-top: 52px;
    }

    .checkout-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.08fr) minmax(320px, .92fr);
        gap: 28px;
        align-items: start;
    }

    .checkout-panel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 8px;
        padding: 22px;
    }

    .checkout-title {
        margin: 0 0 18px;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 700;
    }

    .checkout-form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 12px;
    }

    .checkout-form-field {
        margin-top: 12px;
    }

    .checkout-panel input,
    .checkout-panel select,
    .checkout-panel textarea {
        border-color: var(--line);
        border-radius: 4px;
    }

    .checkout-panel textarea {
        min-height: 118px;
    }

    .checkout-invoice-toggle {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        white-space: nowrap;
    }

    .checkout-invoice-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-top: 12px;
    }

    .place-order-btn {
        width: 100%;
        min-height: 46px;
        border-radius: 4px;
        background: var(--accent) !important;
        border-color: var(--accent) !important;
        color: #fff;
        font-weight: 700;
        letter-spacing: .04em;
    }

    .checkout-summary {
        position: sticky;
        top: 110px;
    }

    .checkout-summary h2 {
        margin: 0 0 16px;
        font-size: 21px;
        line-height: 1.25;
        font-weight: 700;
    }

    .checkout-items {
        display: grid;
        gap: 10px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 12px;
        color: #4c463f;
    }

    .summary-line strong {
        color: var(--text);
    }

    .checkout-total {
        margin: 6px 0 0;
        color: var(--accent);
        font-size: 30px;
        line-height: 1.1;
        font-weight: 700;
        text-align: right;
    }

    .address-status {
        min-height: 22px;
        margin: 12px 0 0;
        color: var(--muted);
        font-size: 14px;
    }

    @media (max-width: 980px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }

        .checkout-summary {
            position: static;
        }
    }

    @media (max-width: 640px) {
        .checkout-page {
            padding-top: 36px;
        }

        .checkout-panel {
            padding: 18px;
        }

        .checkout-form-row {
            grid-template-columns: 1fr;
        }

        .checkout-invoice-grid {
            grid-template-columns: 1fr;
        }

        .checkout-invoice-toggle {
            white-space: normal;
        }
    }
</style>

<section class="section checkout-page" data-checkout-page>
    <div class="container checkout-layout">
        <div class="checkout-panel">
            <h1 class="checkout-title">Thông tin thanh toán</h1>
            <form data-checkout-form>
                <div class="checkout-form-row" style="margin-top:0;">
                    <input type="text" placeholder="Họ tên người nhận" name="customer_name" required>
                    <input type="text" placeholder="Số điện thoại" name="customer_phone" required>
                </div>
                <div class="checkout-form-field">
                    <input type="email" placeholder="Email (không bắt buộc)" name="customer_email">
                </div>
                <div class="checkout-form-field">
                    <input type="text" placeholder="Số nhà, tên đường..." name="shipping_address_detail" required>
                </div>
                <div class="checkout-form-row">
                    <select name="province_id" data-province-select required>
                        <option value="">Chọn Tỉnh/Thành phố</option>
                    </select>
                    <select name="commune_id" data-commune-select required disabled>
                        <option value="">Chọn Phường/Xã</option>
                    </select>
                </div>
                <input type="hidden" name="province_name" value="">
                <input type="hidden" name="commune_name" value="">
                <div class="checkout-form-field">
                    <textarea placeholder="Ghi chú đơn hàng..." name="note"></textarea>
                </div>
                <div class="checkout-form-field">
                    <label class="checkout-invoice-toggle">
                        <input type="checkbox" name="wants_invoice" data-checkout-invoice-toggle>
                        <span>Xuất hóa đơn cho đơn hàng</span>
                    </label>
                    <div data-checkout-invoice-form style="display:none;">
                        <div class="checkout-invoice-grid">
                            <input type="text" placeholder="Tên công ty..." name="invoice_company">
                            <input type="text" placeholder="Mã số thuế..." name="invoice_tax_code">
                            <input type="email" placeholder="Email hóa đơn..." name="invoice_email">
                            <input type="text" placeholder="Địa chỉ công ty..." name="invoice_address">
                        </div>
                    </div>
                </div>
                <div class="checkout-form-field">
                    <button type="submit" class="btn place-order-btn" data-place-order-btn>ĐẶT HÀNG</button>
                </div>
            </form>
        </div>

        <aside class="checkout-summary">
            <div class="checkout-panel">
                <h2>Đơn hàng của bạn</h2>
                <div class="checkout-items" data-checkout-items></div>
                <hr style="border:none; border-top:1px solid var(--line); margin:16px 0;">
                <div class="summary-line">
                    <span>Phí vận chuyển</span>
                    <strong>Miễn phí</strong>
                </div>
                <div class="summary-line">
                    <span>Tổng tiền</span>
                    <strong data-checkout-total>0đ</strong>
                </div>
                <p class="address-status" data-address-api-status></p>
            </div>
        </aside>
    </div>
</section>
@endsection
