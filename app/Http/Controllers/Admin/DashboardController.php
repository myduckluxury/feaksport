<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::where('role', '=', 'user')->count();
        $totalOrders = Order::where('status', '!=', 'canceled')->count();
        $totalSales = Product::sum('sales_count');
        $totalRevenueMonth = Order::where('status', 'completed')->where('payment_status', 'paid')->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('total_final');
        $totalRevenue = Order::where('status', 'completed')->where('payment_status', 'paid')->where('created_at', '>=', Carbon::now()->subMonths(3))->sum('total_final');

        $query = Order::selectRaw("
                    DATE_FORMAT(created_at, '%Y-%m') as raw_month,
                    DATE_FORMAT(created_at, '%m/%Y') as month,
                    SUM(total_final) as revenue
                ")
            ->where('status', 'completed')
            ->where('payment_status', 'paid');

        if ($request->filled('from')) {
            $query->where('created_at', '>=', Carbon::parse($request->from)->startOfDay());
        }

        if ($request->filled('to')) {
            $query->where('created_at', '<=', Carbon::parse($request->to)->endOfDay());
        }

        if (!$request->filled('from') && !$request->filled('to')) {
            $query->where('created_at', '>=', Carbon::now()->subMonths(12));
        }

        $revenueMonth = $query->groupBy('raw_month', 'month')
            ->orderBy('raw_month')
            ->pluck('revenue', 'month');



        $order = Order::selectRaw('status, COUNT(*) as total')
            ->whereIn('status', ['completed', 'canceled'])
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $status = [
            'completed' => 'Hoàn thành.',
            'canceled' => 'Hủy đơn.',
        ];

        $orderStatus = [];
        foreach ($order as $index => $value) {
            $orderStatus[$status[$index]] = $value;
        }

        $statusOrder = [
            'unconfirmed' => ['value' => 'Chờ xác nhận', 'class' => 'bg-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận', 'class' => 'bg-primary'],
            'shipping' => ['value' => 'Đang giao hàng', 'class' => 'bg-warning'],
            'delivered' => ['value' => 'Đã giao hàng', 'class' => 'bg-primary'],
            'completed' => ['value' => 'Hoàn thành', 'class' => 'bg-success'],
            'canceled' => ['value' => 'Đã hủy', 'class' => 'bg-danger'],
            'failed' => ['value' => 'Thất bại.', 'class' => 'bg-danger'],
            'returning' => ['value' => 'Đang hoàn hàng.', 'class' => 'bg-warning'],
            'returned' => ['value' => 'Đơn hoàn trả.', 'class' => 'bg-warning'],
        ];

        $quickListOrders = Order::orderBy('created_at', 'desc')->take(6)->get();
        $topBrands = Brand::select('brands.name')
            ->selectRaw('SUM(products.sales_count) as total_sales')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->groupBy('brands.name')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        $brandLabels = $topBrands->pluck('name');
        $brandSales = $topBrands->pluck('total_sales');

        $productMonth = Product::whereHas('variants')->whereHas('imageLists')->latest('id')->limit(5)->get();
        $productView = Product::whereHas('variants')->whereHas('imageLists')->orderBy('view', 'desc')->limit(6)->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalOrders',
            'totalSales',
            'totalRevenueMonth',
            'totalRevenue',
            'revenueMonth',
            'orderStatus',
            'quickListOrders',
            'productMonth',
            'productView',
            'statusOrder',
            'brandLabels',
            'brandSales'
        ));
    }
}
