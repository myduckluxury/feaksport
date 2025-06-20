<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        // dd($cart);
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return view('client.cart.index', compact('total'));
    }

    public function add(Request $request, Product $product)
    {
        try {
            $cart = session()->get('cart', []);
            $data = $request->validate([
                'color' => ['required'],
                'size' => ['required'],
                'quantity' => ['required', 'min:1']
            ]);

            if ($data['quantity'] == 0 || ctype_digit($data['quantity']) == false) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng không hợp lệ!'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $productVariant = ProductVariant::where('product_id', $product->id)
                ->where('color', $data['color'])
                ->where('size', $data['size'])
                ->first();

            if (!$productVariant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không tìm thấy biến thể sản phẩm!'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($data['quantity'] > $productVariant->quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng bạn chọn vượt quá số lượng hàng có sẵn!'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $product = Product::find($productVariant['product_id']);
            $discount = $product->discount;
            $price = $productVariant->price * (1 - $discount / 100);

            $productIndex = null;

            foreach ($cart as $index => $item) {
                if ($item['id'] == $productVariant->id) {
                    $productIndex = $index;
                    break;
                }
            }


            if ($productIndex !== null) {

                $totalQuantityInCart = $cart[$productIndex]['quantity'] + $data['quantity'];


                if ($totalQuantityInCart > $productVariant->quantity) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Số lượng trong giỏ hàng vượt quá số lượng hàng có sẵn!'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }


                $cart[$productIndex]['quantity'] += $data['quantity'];
            } else {

                $cart[] = [
                    'id' => $productVariant->id,
                    'product_id' => $productVariant->product_id,
                    'image' => $product->imageLists->first()->image_url,
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'color' => $data['color'],
                    'size' => $data['size'],
                    'quantity' => $data['quantity'],
                    'price' => $price
                ];
            }


            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Thêm vào giỏ hàng thành công!',
                'cart' => session()->get('cart')
            ], Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Thêm vào giỏ hàng thất bại!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function destroy()
    {
        try {
            session()->forget('cart');

            return redirect()->route('cart.index')->with('success','Xóa giỏ hàng thành công!');
        } catch (\Throwable $th) {
            return redirect()->route('cart.index')->with('error','Xóa giỏ hàng thất bại');
        }
    }

    public function delete($id)
    {
        try {
            $cart = session()->get('cart', []);

            $cart = array_values(array_filter($cart, function ($item) use ($id) {
                return $item['id'] != $id;
            }));

            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Xóa sản phẩm khỏi giỏ hàng thất bại!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request)
    {
        try {
            if ($request->input('action') === 'update') {
                $data = $request->quantity;
                $cart = session()->get('cart', []);

                foreach ($data as $id => $quantity) {
                    if ($quantity == 0 || ctype_digit($quantity) == false) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Số lượng không hợp lệ.'
                        ], Response::HTTP_INTERNAL_SERVER_ERROR);
                    }

                    $productVariant = ProductVariant::find($id);

                    if (!$productVariant) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Không tìm thấy sản phẩm.'
                        ], Response::HTTP_NOT_FOUND);
                    }

                    foreach ($cart as $index => $item) {
                        if ($item['id'] == $id) {

                            if ($quantity > $productVariant->quantity) {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Số lượng không đủ cho mặt hàng.'
                                ], Response::HTTP_INTERNAL_SERVER_ERROR);
                            }

                            $cart[$index]['quantity'] = $quantity;
                        }

                    }
                }

                session()->put('cart', $cart);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Cập nhật giỏ hàng thành công!',
                ], Response::HTTP_OK);
            } elseif ($request->input('action') === 'filter') {
                $data = $request->all();

                if (empty($data['id'])) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Không có sản phẩm nào được chọn.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $cart = session()->get('cart', []);
                $selectedIds = $data['id'];
                $newCart = [];

                foreach ($cart as $item) {
                    if (in_array($item['id'], $selectedIds)) {
                        if (isset($data['quantity'][$item['id']])) {
                            $quantity = $data['quantity'][$item['id']];

                            if ($quantity == 0 || !ctype_digit($quantity)) {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Số lượng không hợp lệ.'
                                ], Response::HTTP_INTERNAL_SERVER_ERROR);
                            }

                            $productVariant = ProductVariant::find($item['id']);

                            if (!$productVariant) {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Không tìm thấy sản phẩm.'
                                ], Response::HTTP_NOT_FOUND);
                            }

                            if ($quantity > $productVariant->quantity) {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => 'Số lượng không đủ cho mặt hàng.'
                                ], Response::HTTP_INTERNAL_SERVER_ERROR);
                            }

                            $item['quantity'] = $quantity;
                        }

                        $newCart[] = $item;
                    }
                }

                session()->put('cart', $newCart);

                return response()->json([
                    'status' => 'success',
                    'message' => ''
                ], Response::HTTP_OK);

            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật giỏ hàng thất bại!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
