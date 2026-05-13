<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'status' => ['nullable', Rule::in(['new', 'processing', 'completed', 'cancelled'])],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'],
        ]);

        $status = $filters['status'] ?? null;
        $fromDate = $filters['from_date'] ?? null;
        $toDate = $filters['to_date'] ?? null;
        $orders = Order::withCount('items')->latest();

        if ($status) {
            $orders->where('status', $status);
        }

        if ($fromDate) {
            $orders->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate) {
            $orders->whereDate('created_at', '<=', $toDate);
        }

        return view('admin.orders.index', [
            'orders' => $orders->paginate(20)->withQueryString(),
            'filters' => [
                'status' => $status,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ],
        ]);
    }

    public function show(Order $order)
    {
        $order->load('items');
        return view('admin.orders.show', ['order' => $order]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['new', 'processing', 'completed', 'cancelled'])],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
