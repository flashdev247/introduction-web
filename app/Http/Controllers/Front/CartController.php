<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    private function getSettings()
    {
        return (object) [
            'site_name' => Setting::get('site_name', 'HTTM VIETNAM'),
            'logo' => Setting::get('logo', ''),
            'email' => Setting::get('email', ''),
            'phone' => Setting::get('phone', ''),
            'zalo' => Setting::get('zalo', ''),
            'shopee' => Setting::get('shopee', ''),
            'address' => Setting::get('address', ''),
            'contact_info' => Setting::get('contact_info', ''),
        ];
    }

    public function cart()
    {
        return view('front.cart', ['settings' => $this->getSettings()]);
    }

    public function checkout()
    {
        return view('front.checkout', ['settings' => $this->getSettings()]);
    }

    public function storeOrder(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:32'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'shipping_address_detail' => ['required', 'string', 'max:255'],
            'province_id' => ['required', 'string', 'max:32'],
            'province_name' => ['required', 'string', 'max:255'],
            'commune_id' => ['required', 'string', 'max:32'],
            'commune_name' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
            'wants_invoice' => ['nullable', 'boolean'],
            'invoice_company' => ['nullable', 'string', 'max:255'],
            'invoice_tax_code' => ['nullable', 'string', 'max:64'],
            'invoice_email' => ['nullable', 'email', 'max:255'],
            'invoice_address' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', Rule::exists('products', 'id')],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $wantsInvoice = (bool) ($data['wants_invoice'] ?? false);
        if ($wantsInvoice) {
            $request->validate([
                'invoice_company' => ['required', 'string', 'max:255'],
                'invoice_tax_code' => ['required', 'string', 'max:64'],
                'invoice_email' => ['required', 'email', 'max:255'],
                'invoice_address' => ['required', 'string', 'max:255'],
            ]);
        }

        $productIds = collect($data['items'])->pluck('product_id')->unique()->values();
        $products = Product::whereIn('id', $productIds)->where('is_active', true)->get()->keyBy('id');

        if ($products->count() !== $productIds->count()) {
            return response()->json(['message' => 'Một số sản phẩm không còn khả dụng.'], 422);
        }

        $lineItems = [];
        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $product = $products[(int) $item['product_id']];
            $unitPrice = (int) round((float) $product->price);
            $qty = (int) $item['quantity'];
            $lineTotal = $unitPrice * $qty;
            $subtotal += $lineTotal;

            $lineItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $unitPrice,
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        if ($subtotal < 500000) {
            return response()->json(['message' => 'Chỉ nhận thanh toán đơn từ 500.000đ trở lên.'], 422);
        }

        $order = DB::transaction(function () use ($data, $lineItems, $subtotal, $wantsInvoice) {
            $order = Order::create([
                'code' => 'HTTM' . now()->format('ymdHis') . random_int(10, 99),
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'shipping_address_detail' => $data['shipping_address_detail'],
                'province_id' => $data['province_id'],
                'province_name' => $data['province_name'],
                'commune_id' => $data['commune_id'],
                'commune_name' => $data['commune_name'],
                'note' => $data['note'] ?? null,
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'wants_invoice' => $wantsInvoice,
                'invoice_company' => $wantsInvoice ? ($data['invoice_company'] ?? null) : null,
                'invoice_tax_code' => $wantsInvoice ? ($data['invoice_tax_code'] ?? null) : null,
                'invoice_email' => $wantsInvoice ? ($data['invoice_email'] ?? null) : null,
                'invoice_address' => $wantsInvoice ? ($data['invoice_address'] ?? null) : null,
                'status' => 'new',
            ]);

            $order->items()->createMany($lineItems);
            return $order;
        });

        return response()->json([
            'message' => 'Đặt hàng thành công.',
            'order_code' => $order->code,
        ]);
    }
}
