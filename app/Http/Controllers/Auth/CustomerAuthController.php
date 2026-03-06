<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CustomerAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('customer.auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
        ]);
        Auth::login($user);
        return redirect()->route('home')->with('success', 'Đăng ký thành công! Chào mừng đến với Fruitkha!');
    }
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $remember = $request->filled('remember');
        // attempt() là một phương thức (method) của Facade Auth (Lớp xác thực).
        // Nó cố gắng "thử" (attempt) đăng nhập người dùng dựa trên thông tin bạn cung cấp.
        // biến credentials là mảng chứa pas và email, còn remember trả về true false
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); //Tạo ra một Session ID mới và xóa Session ID cũ Đảm bảo Hacker không thể sử dụng Session ID cũ (đã biết trước) để giả mạo người dùng sau khi họ đăng nhập thành công.
            if (Auth::user()->is_admin == 1) {
                return redirect()->intended('/admin/products')->with('success', 'Đăng nhập Admin thành công!');
            }
            //hàm intended() là chuyển hướng đến trang ban đầu dự trên session , nếu ko có thì tiến thẳng home
            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');
        }
        //back() chuyển hướng quya lại form
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không hợp lệ.',
        ])->onlyInput('email'); //giữ lại trường email khi sai
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); //tất cả dữ liệu được lưu trữ trong Session trước đó (ví dụ: thông báo flash, giỏ hàng,...) sẽ bị xóa bỏ hoàn toàn, và Session ID đó không thể được sử dụng lại.
        $request->session()->regenerateToken(); //Bảo mật Token CSRF,Tạo ra một mã token mới cho các form tiếp theo, là một biện pháp bảo mật tốt để ngăn chặn việc sử dụng lại token cũ sau khi đăng xuất.
        return redirect('/')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}
