<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(6); // Hiển thị 6 bài trên mỗi trang
        return view('client.blog.index', compact('blogs'));
    }

    public function detail($id)
    {
        $blog = Blog::findOrFail($id);
        return view('client.blog.detail', compact('blog'));
    }

    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('client.blog.show', compact('blog'));
    }
}
