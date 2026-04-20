<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show the payment confirmation form.
     */
    public function show(Order $order)
    {
        // Ensure user can only access their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // Only allow payment upload for pending orders
        if (!in_array($order->status, ['pending'])) {
            return redirect()->route('dashboard')->with('error', 'Pesanan ini sudah dikonfirmasi atau sedang diproses.');
        }

        $paymentMethods = \App\Models\PaymentMethod::active()->get();

        return view('orders.payment', compact('order', 'paymentMethods'));
    }

    /**
     * Store the payment proof.
     */
    public function store(Request $request, Order $order)
    {
        // Ensure user can only access their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        if (!in_array($order->status, ['pending'])) {
            return redirect()->route('dashboard')->with('error', 'Pesanan ini sudah dikonfirmasi.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        // Save the image
        $imageName = 'payment-' . $order->id . '-' . time() . '.' . $request->payment_proof->extension();
        $request->payment_proof->move(public_path('assets/payments'), $imageName);

        // Update order
        $order->update([
            'payment_proof' => $imageName,
            'status' => 'payment_uploaded',
        ]);

        return redirect()->route('order.success', $order)->with('success', 'Bukti pembayaran berhasil diunggah! Kami akan segera memverifikasi.');
    }
}
