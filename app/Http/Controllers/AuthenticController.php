<?php

namespace App\Http\Controllers;

use App\Mail\VerifyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class AuthenticController extends Controller
{
    public function index()
    {
        return view('auth.signin');
    }

    public function formSignup()
    {
        return view('auth.signup');
    }

    public function signin(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);
        if (Auth::attempt($data)) {
            if (Auth::user()->status == 1 && Auth::user()->email_verified_at != null) {
                $user = Auth::user();
                if (Auth::user()->role == 'staff' || Auth::user()->role == 'manager') {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Đăng nhập thành công.',
                        'role' => $user->role
                    ], Response::HTTP_OK);
                } else {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Đăng nhập thành công.',
                        'role' => $user->role
                    ], Response::HTTP_OK);
                }
            } elseif (Auth::user()->email_verified_at == null) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tài khoản chưa được xác thực, vui lòng kiểm tra email.'
                ], Response::HTTP_UNAUTHORIZED);

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tài khoản đã bị khóa.'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Email hoặc mật khẩu không chính xác.'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function signup(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'name' => ['required', 'min:4'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:password']
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
            'name.required' => 'Họ tên không để trống.',
            'name.min' => 'Họ tên tối thiểu 4 ký tự.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu tối thiểu 8 ký tự.',
            'confirm_password.required' => 'Không được bỏ trống.',
            'confirm_password.min' => 'Tối thiểu 8 ký tự.',
            'confirm_password.same' => 'Mật khẩu không khớp,vui lòng nhập lại.'
        ]);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if($user) {
            Mail::to($user->email)->send(new VerifyAccount($user));
            return response()->json([
                'status' => 'success',
                'message' => 'Tạo tài khoản thành công, kiểm tra email để xác nhận.'
            ], Response::HTTP_OK);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('signin')->with('success', 'Đăng xuất thành công.');
    }

    public function profile()
    {
        return view('client.user.index');
    }
    public function changePassword()
    {
        return view('client.user.changepassword');
    }

    public function updatePassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required', 'min:8'],
            'new_password' => ['required', 'min:8', 'different:password'],
            'confirm_new_password' => ['required', 'min:8', 'same:new_password']
        ], [
            'password.required' => 'Không được để trống.',
            'password.min' => 'Tối thiểu 8 ký tự.',
            'new_password.required' => 'Không được để trống.',
            'new_password.min' => 'Tối thiểu 8 ký tự.',
            'new_password.different' => 'Không được trùng với mật khẩu cũ.',
            'confirm_new_password.required' => 'Không được để trống.',
            'confirm_new_password.min' => 'Tối thiểu 8 ký tự.',
            'confirm_new_password.same' => 'Mật khẩu không khớp.',
        ]);

        if (!Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu cũ không chính xác.'
            ], Response::HTTP_UNAUTHORIZED);

        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công.'
        ], Response::HTTP_OK);
    }
    
    
}



