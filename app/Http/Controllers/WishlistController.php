<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, Product $product)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $wishlisted = false;
            $message = 'Produk dihapus dari wishlist.';
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
            ]);
            $wishlisted = true;
            $message = 'Produk ditambahkan ke wishlist!';
        }

        return response()->json([
            'wishlisted' => $wishlisted,
            'message'    => $message,
        ]);
    }
}
