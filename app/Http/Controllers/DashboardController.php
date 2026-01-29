<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_customers' => Customer::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::sum('total'),
        ];

        $recentTransactions = Transaction::with('customer')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentTransactions', 'lowStockProducts'));
    }
}
