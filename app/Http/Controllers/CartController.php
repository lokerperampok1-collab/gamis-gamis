<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $coupon = session()->get('coupon');
        if ($coupon) {
            $couponModel = Coupon::where('code', $coupon)->first();
            if ($couponModel && $couponModel->isValid($total)) {
                $discount = $couponModel->calculateDiscount($total);
            } else {
                session()->forget('coupon');
            }
        }

        return view('cart', compact('cart', 'total', 'discount', 'coupon'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Produk berhasil dihapus!');
        }
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Keranjang berhasil diperbarui!');
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon || !$coupon->isValid($total)) {
            return back()->with('error', 'Kupon tidak valid, kadaluarsa, atau minimum belanja belum tercapai.');
        }

        session()->put('coupon', $coupon->code);

        return back()->with('success', 'Kupon berhasil diterapkan!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Kupon berhasil dilepas!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:255',
            'zip' => 'required|string|max:10',
            'payment_method' => 'required|string',
        ]);

        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->route('home');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $couponId = null;
        $discountAmount = 0;
        $couponCode = session()->get('coupon');

        if ($couponCode) {
            $couponModel = Coupon::where('code', $couponCode)->first();
            if ($couponModel && $couponModel->isValid($total)) {
                $discountAmount = $couponModel->calculateDiscount($total);
                $couponId = $couponModel->id;
                
                // Increment usage count
                $couponModel->increment('used_count');
            }
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'payment_method' => $request->payment_method,
            'total_price' => max(0, $total - $discountAmount),
            'coupon_id' => $couponId,
            'discount_amount' => $discountAmount,
            'status' => 'pending',
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);

            // Deduct stock
            $product = Product::find($id);
            if ($product) {
                $product->stock -= $details['quantity'];
                $product->save();
            }
        }

        session()->forget('cart');
        session()->forget('coupon');

        // Send Telegram Notification
        try {
            $telegram = new \App\Services\TelegramService();
            $message = "🛍 *PESANAN BARU MASUK*\n\n";
            $message .= "🆔 *Order ID:* #".str_pad($order->id, 6, '0', STR_PAD_LEFT)."\n";
            $message .= "👤 *Pelanggan:* {$order->first_name} {$order->last_name}\n";
            $message .= "💰 *Total:* Rp " . number_format($order->total_price, 0, ',', '.') . "\n";
            $message .= "💳 *Metode:* " . ucfirst(str_replace('_', ' ', $order->payment_method)) . "\n\n";
            $message .= "🚀 Segera cek dashboard admin untuk verifikasi!";
            
            $telegram->sendMessage($message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send checkout notification: " . $e->getMessage());
        }

        return redirect()->route('order.success', $order->id)->with('success', 'Pesanan Anda berhasil dibuat!');
    }
}
