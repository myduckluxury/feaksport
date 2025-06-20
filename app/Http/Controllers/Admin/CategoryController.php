<?php

namespace App\Http\Controllers\Admin;

use App\Events\CategoryChange;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $query = Category::query();

        if ($keyword = request()->keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

       
        $categories = $query->latest('id')->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:4', Rule::unique('categories')->whereNull('deleted_at'),]
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.min' => 'Tên danh mục phải có ít nhất 4 ký tự.',
            'name.unique' => 'Tên danh mục đã tồn tại, vui lòng nhập tên khác.',
            'name.regex' => 'Tên danh mục không hợp lệ.'
        ]);

        $category = Category::create($data);
        event(new CategoryChange($category));

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm danh mục thành công!'
        ], Response::HTTP_OK);
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'min:4', Rule::unique('categories')->whereNull('deleted_at')->ignore($category->id)],
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.min'      => 'Tên danh mục phải có ít nhất 4 ký tự.',
            'name.unique'   => 'Tên danh mục đã tồn tại, vui lòng nhập tên khác.',
            'name.regex'    => 'Tên danh mục không hợp lệ.'
        ]);

        $category->update($data);
        event(new CategoryChange($category));

        if ($request->ajax()) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Cập nhật danh mục thành công.'
            ], Response::HTTP_OK);
        }

        return redirect()->back();
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            event(new CategoryChange($category));
            return redirect()->back()->with('success', 'Xóa thành công!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Xóa không thành công!');
        }
    }
}
