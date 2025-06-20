<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        $parts = explode(',', $user->address);
        $parts = array_map('trim', $parts);
        $count = count($parts);

        $province = $parts[$count - 1] ?? null;
        $district = $parts[$count - 2] ?? null;
        $address = $parts[$count - 3] ?? null;
        $role = [
            'staff' => 'Nhân viên',
            'manager' => 'Quản trị viên'
        ];

        return view('admin.profile.index', compact('role', 'parts', 'user', 'province', 'district', 'address'));
    }

    public function edit(User $user) {
        $parts = explode(',', $user->address);
        $parts = array_map('trim', $parts);
        $count = count($parts);

        $province = $parts[$count - 1] ?? null;
        $district = $parts[$count - 2] ?? null;
        $address = $parts[$count - 3] ?? null;

        return view('admin.profile.edit', compact('user', 'parts', 'province', 'district', 'address'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','min:4'],
            'phone_number' => ['required','string','max:15'],
            'address' => ['required','string','min:4'],
            'avatar' => ['nullable','mimes:jpeg,png,jpg,avitf,webp'],
        ], [
            'name.required' => 'Tên không được để trống',
            'name.string' => 'Tên không được chứa ký tự đặc biệt',
            'name.min' => 'Tên tối thiểu 4 ký tự',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.string' => 'Số điện thoại không được chứa ký tự đặc biệt',
            'phone_number.max' => 'Số điện thoại tối đa 15 ký tự',
            'address.required' => 'Địa chỉ không được để trống',
            'address.string' => 'Địa chỉ không được chứa ký tự đặc biệt',
            'address.min' => 'Địa chỉ tối thiểu 4 ký tự',
            'avatar.image' => 'Hình ảnh không đúng định dạng',
            'avatar.mimes' => 'Hình ảnh không đúng định dạng',
        ]);

        $data['address'] = $request->input('address') . ', ' . $request->input('district') . ', ' . $request->input('province');

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
        ]);
    }

    public function change (User $user) {
        return view('admin.profile.change-password', compact('user'));
    }

    public function update_pass(User $user, Request $request) {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'old_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'different:old_password'],
            'confirm_password' => ['required', 'same:password'],
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'old_password.required' => 'Mật khẩu cũ không được để trống',
            'old_password.string' => 'Mật khẩu cũ không được chứa ký tự đặc biệt',
            'old_password.min' => 'Mật khẩu cũ tối thiểu 8 ký tự',
            'password.required' => 'Mật khẩu mới không được để trống',
            'password.string' => 'Mật khẩu mới không được chứa ký tự đặc biệt',
            'password.min' => 'Mật khẩu mới tối thiểu 8 ký tự',
            'password.different' => 'Mật khẩu mới không được trùng với mật khẩu cũ',
            'confirm_password.required' => 'Xác nhận mật khẩu không được để trống',
            'confirm_password.same' => 'Mật khẩu không khớp',
        ]);

        if ($data['email'] != $user->email) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email không đúng'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        if (!Hash::check($data['old_password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu cũ không đúng'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật mật khẩu thành công'
        ], Response::HTTP_OK);
    }
}
