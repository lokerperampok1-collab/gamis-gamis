<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order, Product $product)
    {
        // 1. Validasi
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        // 2. Pastikan yang login yang review
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Akses tidak sah');
        }

        // 3. Pastikan status order 'completed'
        if ($order->status !== 'completed') {
            return back()->with('error', 'Hanya pesanan yang sudah selesai yang bisa direview.');
        }

        // 4. Pastikan produk ada di order_items pesanan ini
        $hasProduct = $order->items()->where('product_id', $product->id)->exists();
        if (!$hasProduct) {
            return back()->with('error', 'Produk tidak ditemukan dalam pesanan ini.');
        }

        // 5. Pastikan user belum nge-review produk di transaksi ini
        $existingReview = Review::where('user_id', auth()->id())
            ->where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini.');
        }

        // 6. Simpan Ulasan
        Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
