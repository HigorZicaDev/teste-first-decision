<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'total_products' => Product::count(),
            'total_stock' => (int) Product::sum('quantity_in_stock'),
            'inventory_value' => (float) Product::sum(DB::raw('price * quantity_in_stock')),
            'low_stock' => Product::where('quantity_in_stock', '<=', 9)->count(),
            'out_of_stock' => Product::where('quantity_in_stock', 0)->count(),
        ];

        $lowStockProducts = Product::where('quantity_in_stock', '<=', 9)
            ->orderBy('quantity_in_stock')
            ->limit(10)
            ->get();

        return view('painel.dashboard', compact('metrics', 'lowStockProducts'));
    }
}
