<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function edit()
    {
        return view('client.user.updateprofile');
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'min:4'],
                'phone_number' => ['required', 'phone:VN'],
                'avatar' => ['nullable', 'image'],
                'address' => ['required', 'min:4']
            ], [
                'name.required' => 'Không được để trống.',
                'name.min' => 'Tối thiểu 4 ký tự.',
                'phone_number.required' => 'Không được để trống.',
                'phone_number.phone' => 'Số điện thoại không hợp lệ.',
                'address.required' => 'Không được để trống.',
                'address.min' => 'Tối thiểu 4 ký tự.'
            ]);

            $user = User::findOrFail(Auth::user()->id);

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::delete($user->avatar);
                }
                $data['avatar'] = $request->file('avatar')->store('images/avatar');
            }

            $user->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin thành công.'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
