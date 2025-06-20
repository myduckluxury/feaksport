<?php

namespace App\Http\Controllers\Admin;

use App\Events\ProductChange;
use App\Http\Controllers\Controller;
use App\Models\ImageList;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageListController extends Controller
{
    public function uploadFile(Request $request,$filename) {
        $uploadFiles = [];
        if ($request->hasFile($filename)) {
            $files = is_array($request->file($filename)) ? $request->file($filename) : [$request->file($filename)];

            foreach ($files as $file) {
                $path =  $file->store('images/products');
                $uploadFiles[] = $path;
            }
        }

        return $uploadFiles;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image_url'     => ['required', 'array',],
            'image_url.*'   => ['required', 'image'],
            'product_id'    => ['nullable'],
        ], [
            'image_url.required'    => 'Không được để trống.',
            'image_url.array'       => 'Dữ liệu gửi lên không hợp lệ.',
            'image_url.*.required'  => 'Không được để trống.',
            'image_url.*.image'     => 'Tệp không hợp lệ.'
        ]);

        if (!empty($data['image_url'])) {
            $data['image_url'] = $this->uploadFile($request, 'image_url');
            foreach ($data['image_url'] as $item) {
                ImageList::create([
                    'product_id'    => $data['product_id'],
                    'image_url'     => $item
                ]);
            }
        }
        $product = Product::where('id', $data['product_id'])->first();
        event(new ProductChange($product->id, $product));
        if ($request->ajax()) {
            return response()->json([
                'status'    => 'success',
                'message'   => 'Thêm ảnh thành công.'
            ], Response::HTTP_OK);
        }

        return redirect()->back();
    }

    public function destroy($id) {
        $image = ImageList::where('id', $id)->first();
        // dd($image);
        if($image) {
            Storage::delete($image->image_url);
        }

        $image->delete();

        $product = Product::where('id', $image->product_id)->first();
        event(new ProductChange($product->id, $product));

        return redirect()->back()->with('success', 'Xóa thành công.');
    }
}
