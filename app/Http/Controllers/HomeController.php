<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::whereHas('variants')->where('featured', true)->latest('id')->paginate(10);
        $sellWell = Product::whereHas('variants')->get();
        $blogs = Blog::latest()->paginate(3);
        return view('client.home.home', compact('products', 'sellWell','blogs'));
    }
}
