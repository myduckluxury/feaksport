<?php

namespace App\Http\Controllers\Admin;

use App\Events\UserChange;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function listUser(Request $request)
    {

        $query = User::query();

        if ($request->keyword) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('email', 'LIKE', "%{$request->keyword}%");
            });
        }

        if ($request->status === 'active') {
            $query->where('status', 1);
        } elseif ($request->status === 'banned') {
            $query->where('status', 0);
        } elseif ($request->status === 'unconfirmed') {
            $query->whereNull('email_verified_at');
        }

        $users = $query->latest('id')->where('role', 'user')->paginate(10);
        $status = [
            1 => ['value' => 'Hoạt động', 'class' => 'text-success'],
            0 => ['value' => 'Vô hiệu hóa', 'class' => 'text-danger']
        ];
        $role = [
            'user' => 'Người dùng',
        ];
        return view('admin.users.list', compact('users', 'status', 'role'));
    }
    public function edit(Request $request, User $user)
    {
        try {
            $user->status = $request->status;
            $user->save();
            event(new UserChange);
            return redirect()->back()->with('success', 'Cập nhật thành công.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function verify(User $user)
    {
        if (!$user->email_verified_at) {
            $user->email_verified_at = Carbon::now()->format('d-m-Y H:i:s');
            $user->save();
            event(new UserChange);
        }

        return redirect()->back()->with('success', 'Xác nhận thành công.');
    }
}
