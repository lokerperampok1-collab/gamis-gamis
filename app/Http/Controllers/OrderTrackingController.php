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

        if ($request->filled('tracking_number') && $request->filled('email')) {
            $searched = true;
            
            $order = Order::with(['items.product', 'trackingLogs'])
                ->where('tracking_number', $request->tracking_number)
                ->where('email', $request->email)
                ->first();
        }

        return view('order-track', compact('order', 'searched'));
    }
}
