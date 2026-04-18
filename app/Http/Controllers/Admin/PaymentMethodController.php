<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::all();
        return view('admin.payment_methods.index', compact('methods'));
    }

    public function create()
    {
        return view('admin.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'type' => 'required|in:bank,e_wallet',
            'is_active' => 'boolean',
            'instructions' => 'nullable|string',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
            'instructions' => $request->instructions,
        ]);

        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil ditambahkan.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'type' => 'required|in:bank,e_wallet',
            'is_active' => 'boolean',
            'instructions' => 'nullable|string',
        ]);

        $paymentMethod->update([
            'name' => $request->name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
            'instructions' => $request->instructions,
        ]);

        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('admin.payment_methods.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
