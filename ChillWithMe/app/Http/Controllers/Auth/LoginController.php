<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $req)
    {
        $validator = Validator::make($req->all(),[
            'email' => ['required','email'],
            'password'=>['required', 'min:8', 'max:30'],
        ],[
            'email.required'=>'Nhập tên đăng nhập',
            'email.email'=>'Email không hợp lệ',
            'password.required'=>'Nhập mật khẩu',
            'password.min'=>'Mật khẩu có ít nhất 8 kí tự',
            'password.max'=>'Mật khẩu có tối đa 30 kí tự'
        ]);
        
        if($validator->fails()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        } else {
            if (!Auth::attempt([
                'email'=>$req->input('email'),
                'password'=>$req->input('password')
            ])) {
                return response()->json(['status'=>1, 'msg'=>'Your email or password is incorrect. Please try again']);
            } else if (Auth::attempt([
                'email'=>$req->input('email'),
                'password'=>$req->input('password')
            ])) {
                return response()->json(['status'=>2, 'msg'=>'Login Successfully']);
            } else {
                return response()->json(['status'=>3, 'msg'=>'Something went wrong. Can not login with your email and password']);
            }
        }
    }
}
