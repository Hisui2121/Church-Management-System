<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(15);

        $pendingCount = Order::where('status', 'Pending')->count();

        return view('admin.orders.index', compact('orders', 'pendingCount'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status'        => 'required|in:Pending,Approved,Rejected,Completed',
            'admin_notes'   => 'nullable|string',
        ]);

        $oldStatus = $order->status;

        if (in_array($validated['status'], ['Approved', 'Rejected', 'Completed'])) {
            $validated['resolved_at'] = now();
        }

        $order->update($validated);

        AuditLog::record('Updated', 'orders', $order->id, "Order '{$order->title}' status: {$oldStatus} → {$validated['status']}");

        return redirect()->route('admin.orders.index')
            ->with('success', "Order status updated to {$validated['status']}.");
    }

    public function destroy(Order $order)
    {
        $orderId = $order->id;
        $orderTitle = $order->title;
        $order->delete();

        AuditLog::record('Deleted', 'orders', $orderId, "Order '{$orderTitle}' deleted");

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted.');
    }
}
