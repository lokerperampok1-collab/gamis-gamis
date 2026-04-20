<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'recentOrders'));
    }

    public function products()
    {
        $products = Product::with('category')->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $imageName = Str::slug($request->name) . '-' . Str::random(5) . '.' . $request->image->extension();
        $request->image->move(public_path('assets/product'), $imageName);

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . Str::random(5)),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'description' => $request->description,
            'stock' => $request->stock,
        ];

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->name) . '-' . Str::random(5) . '.' . $request->image->extension();
            $request->image->move(public_path('assets/product'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui!');
    }

    public function deleteProduct(Product $product)
    {
        // Delete image file
        $imagePath = public_path('assets/product/' . $product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus!');
    }

    // ─── Order Management ─────────────────────────────────

    public function orders(Request $request)
    {
        $query = Order::with('user')->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(15)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function verifyOrder(Order $order)
    {
        if ($order->status !== 'payment_uploaded') {
            return back()->with('error', 'Pesanan ini tidak dalam status menunggu verifikasi.');
        }

        // Auto-generate tracking number (Resi) similar to common courier formats (RT + numbers + random letters)
        $trackingNumber = 'RT' . rand(10, 99) . rand(1000, 9999) . rand(1000, 9999) . strtoupper(Str::random(2));

        $order->update([
            'status' => 'processing',
            'tracking_number' => $trackingNumber
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi! Pesanan sedang diproses dengan Resi Otomatis: ' . $trackingNumber);
    }

    public function rejectOrder(Order $order)
    {
        if ($order->status !== 'payment_uploaded') {
            return back()->with('error', 'Pesanan ini tidak dalam status menunggu verifikasi.');
        }

        // Delete proof image
        if ($order->payment_proof) {
            $path = public_path('assets/payments/' . $order->payment_proof);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $order->update([
            'status' => 'pending',
            'payment_proof' => null,
        ]);

        return back()->with('success', 'Pembayaran ditolak. Pelanggan dapat mengunggah ulang bukti transfer.');
    }

    public function shipOrder(Request $request, Order $order)
    {
        if ($order->status !== 'processing') {
            return back()->with('error', 'Status pesanan tidak sesuai untuk dikirim.');
        }

        $request->validate([
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $order->update([
            'status' => 'shipped',
            'tracking_number' => $request->tracking_number,
        ]);

        return back()->with('success', 'Pesanan berhasil dikirim!');
    }

    public function completeOrder(Order $order)
    {
        if ($order->status !== 'shipped') {
            return back()->with('error', 'Status pesanan tidak sesuai untuk diselesaikan.');
        }

        $order->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Pesanan telah selesai.');
    }

    public function cancelOrder(Order $order)
    {
        if (in_array($order->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'Pemesanan yang telah selesai atau dibatalkan tidak dapat diubah lagi.');
        }

        // Return stock
        $order->load('items.product');
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
    }
}
