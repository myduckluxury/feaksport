<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffController extends Controller
{
    public function index(Request $request)
    {

        $query = User::where('role', 'staff');

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

        $staffs = $query->latest('id')->paginate(10);

        $allStaffs = User::where('role', 'staff')->get();
        $status = [
            1 => ['value' => 'Hoạt động', 'class' => 'text-success'],
            0 => ['value' => 'Vô hiệu hóa', 'class' => 'text-danger']
        ];

        return view('admin.staff.index', compact('staffs', 'status'));
    }

    public function status(Request $request, User $user)
    {
        $action = $request->input('action');
        if ($action == 'ban') {
            $user->status = 0;
            $user->save();
        }

        if ($action == 'unban') {
            $user->status = 1;
            $user->save();
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái tài khoản thành công.');
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
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
            'confirm_password.same' => 'Mật khẩu không khớp, vui lòng nhập lại.'
        ]);

        $data['role'] = 'staff';
        $data['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
        $staff = User::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo tài khoản thành công.'
        ], Response::HTTP_OK);
    }
}
