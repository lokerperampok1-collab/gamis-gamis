<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('is_admin', false)
            ->withCount('orders')
            ->withSum(['orders as total_spent' => function ($query) {
                $query->whereIn('status', ['payment_uploaded', 'processing', 'shipped', 'completed']);
            }], 'total_price')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        if ($customer->is_admin) {
            abort(404); // Or redirect back, admins shouldn't be viewed here
        }

        $orders = $customer->orders()->latest()->paginate(10);
        $totalSpent = $customer->orders()
            ->whereIn('status', ['payment_uploaded', 'processing', 'shipped', 'completed'])
            ->sum('total_price');

        return view('admin.customers.show', compact('customer', 'orders', 'totalSpent'));
    }
}
