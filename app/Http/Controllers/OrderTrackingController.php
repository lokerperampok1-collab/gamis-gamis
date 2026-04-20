<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Show the tracking page or handle the tracking request.
     */
    public function index(Request $request)
    {
        $order = null;
        $searched = false;

        if ($request->filled('order_id') && $request->filled('email')) {
            $searched = true;
            
            // Clean order_id from '#' if present
            $orderId = str_replace('#', '', $request->order_id);
            // Remove leading zeros if it was padded
            $orderId = (int)$orderId;

            $order = Order::with('items.product')
                ->where('id', $orderId)
                ->where('email', $request->email)
                ->first();
        }

        return view('order-track', compact('order', 'searched'));
    }
}
