<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $query = Product::query();
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = (int) $request->min_price;
            $maxPrice = (int) $request->max_price;

            $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereRaw('(product_variants.price - (product_variants.price * products.discount / 100)) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            });
        }
        // Sắp xếp (sort by)
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('sales_count', 'desc');
                    break;
                case 'rating':
                    $query->withAvg('reviews', 'rating')
                        ->orderBy('reviews_avg_rating', 'desc');
                    break;
                case 'newness':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->latest('id');
            }
        } else {
            $query->latest('id'); // Default sort
        }
        $products = $query->whereHas('variants')->latest('id')->paginate(10);
        return view('client.product.index', compact('products', 'categories', 'brands'));
    }

    public function detail(Request $request, $id, $slug)
    {
        $product = Product::with('category', 'brand', 'imageLists')->where('slug', $slug)->find($id);
        $nextProduct = Product::where('id', '>', $id)->orderBy('id', 'asc')->first();

        if (!$product) {
            return abort(404);
        }

        $ratingFilter = $request->query('rating');

        $user = Auth::user();
        $order = null;
        $variant = null;
        $orderItems = collect(); // Khởi tạo rỗng
        $hasPurchased = false;

        if ($user) {
            $orderItems = OrderItem::with('product_variant')
                ->whereHas('order', function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->where('status', 'completed');
                })
                ->whereHas('product_variant', function ($q) use ($id) {
                    $q->where('product_id', $id);
                })
                ->get();

            $hasPurchased = $orderItems->isNotEmpty();

            $filteredOrderItems = $orderItems->filter(function ($item) use ($user) {
                return !Review::where('user_id', $user->id)
                    ->where('product_variant_id', $item->product_variant_id)
                    ->where('order_id', $item->order_id)
                    ->exists();
            });

            $orderItems = $filteredOrderItems;
            $order = $filteredOrderItems->first()?->order;
            $variant = $filteredOrderItems->first()?->product_variant;
        }

        $allReviews = Review::where('product_id', $id)
            ->where('status', true)
            ->get();

        $averageRating = round($allReviews->avg('rating'), 1);
        $totalReviews = $allReviews->count();

        $reviews = Review::where('product_id', $id)
            ->where('status', true)
            ->when($ratingFilter, function ($query) use ($ratingFilter) {
                $query->where('rating', $ratingFilter);
            })
            ->with(['user', 'variant'])
            ->latest()
            ->paginate(5)
            ->appends(['rating' => $ratingFilter]);

        $products = Product::with('category', 'brand', 'imageLists')->has('variants')->has('imageLists')->get();

        $product->increment('view');

        return view('client.product.detail', compact(
            'product',
            'id',
            'products',
            'reviews',
            'order',
            'variant',
            'orderItems',
            'hasPurchased',
            'averageRating',
            'totalReviews',
            'ratingFilter'
        ));
    }

    public function product($id)
    {
        $product = Product::with('variants')->find($id);
        return view('product-detail', compact('product'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categories = Category::all();
        $brands = Brand::all();

        if ($keyword) {
            $products = Product::where('name', 'LIKE', "%$keyword%")->has('variants')->has('imageLists')->latest('id')->paginate(10);
        } else {
            $products = Product::latest('id')->has('variants')->has('imageLists')->paginate(10);
        }

        return view('client.product.index', compact('products', 'categories', 'brands'));
    }
}
