<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerifyAccountController extends Controller
{
    public function verify($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $now = Carbon::now()->format('Y-m-d H:i:s');
        if($user->email_verified_at == null) {
            $user->update([
                'email_verified_at' => $now,
            ]);
            return redirect()->route('signin')->with('success', 'Xác thực tài khoản thành công, vui lòng đăng nhập lại.');
        } else {
            abort(404);
        }
    }
}
