<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot');
    }
    public function forgot(Request $request)
    {
        $data = $request->validate([
            'email' => ['required',
            'exists:users',
            'email']
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.exists' => 'Email không tồn tại.',
            'email.email' => 'Email không hợp lệ.'
        ]);

        $user = User::where('email', $data['email'])->first();
        $token = Str::random(60);
        $now = Carbon::now();
        if ($user) {
            PasswordResetToken::updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => $token,
                    'created_at' => $now
                ]
            );

            Mail::to($user->email)->send(new ForgotPassword($user, $token, $now));

            return redirect()->route('signin')->with('success', 'Thành công. Vui lòng kiểm tra email của bạn, hãy kiểm tra cả mục thư rác.');
        } else {
            return redirect()->back()->with('error', 'Email khong tồn tại trên hệ thống.');
        }
    }

    public function confirm($token)
    {
        $checkUser = PasswordResetToken::where('token', $token)->first();

        if ($checkUser) {
            return view('auth.reset-password', compact('token'));
        } else {
            abort(404);
        }
    }

    public function reset(Request $request, $token)
    {
        $data = $request->validate([
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:password']
        ], [
            'password.required' => 'Mật khâu không được bỏ trống.',
            'password.min' => 'Tối thiểu 8 ký tự.',
            'confirm_password.required' => 'Mật khâu không được bỏ trống.',
            'confirm_password.same' => 'Mật khâu không khớp.'
        ]);

        $checkUser = PasswordResetToken::where('token', $token)->first();
        // dd($checkUser);
        $user = User::where('email', $checkUser->email)->first();

        $user->update([
            'password' => $data['password']
        ]);

        PasswordResetToken::where('token', $token)->delete();

        return redirect()->route('signin')->with('success', 'Đặt lại mật khẩu thành công. Vui lòng đăng nhập.');
    }
}
