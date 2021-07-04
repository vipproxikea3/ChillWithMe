<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function authenticate(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 
                function($attribute, $value, $fail){
                    $user = User::where('email', $value)->first();
                    if($user){
                        return $fail(__('Email đã được đăng ký'));
                    }
                },
            ],
            'password' => ['required', 'min:8', 'max:30'],
            'password_confirmation' => ['required', 'same:password'],
        ],[
            'name.required'=>'Nhập họ và tên',
            'name.string'=>'Họ và tên là một chuỗi kí tự',
            'name.max'=>'Họ và tên có tối đa 255 kí tự',
            'email.required'=>'Nhập email',
            'email.email'=>'Email không hợp lệ',
            'password.required'=>'Nhập mật khẩu',
            'password.min'=>'Mật khẩu có ít nhất 8 kí tự',
            'password.max'=>'Mật khẩu có tối đa 30 kí tự',
            'password_confirmation.required'=>'Vui lòng xác nhận mật khẩu',
            'password_confirmation.same'=>'Không trùng khớp với mật khẩu',
        ]);

        if($validator->fails()) {
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        } else {
            $user = User::create([
                'name' => $req['name'],
                'email' => $req['email'],
                'password' => Hash::make($req['password']),
            ]);
        }
        
            if($user->save()) {
                $this->guard()->login($user);
                return response()->json(['status'=>1,'msg'=>'Register Successfully']);
            } else {
                return response()->json(['status'=>0,'msg'=>'Something went wrong. Can not register']);
            }
    }

    // /**
    //  * Get a validator for an incoming registration request.
    //  *
    //  * @param  array  $data
    //  * @return \Illuminate\Contracts\Validation\Validator
    //  */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //     ]);
    // }

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\Models\User
    //  */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }
}
