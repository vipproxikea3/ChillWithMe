<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Pusher\Pusher;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $room = Room::where('idRoom', Auth::user()->id)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $user->idRoom = NULL;
        $user->save();

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        );
        $pusher->trigger('room', 'member', null);

        if (!isset($room)) {
            $room = new Room;
            $room->password = NULL;
        }
        return view('home', ['room' => $room]);
    }

    public function updatePass(Request $req)
    {
        $room = Room::where('idRoom', Auth::user()->id)->first();
        $room->password = $req->newRoomPass;
        $room->save();
        return back();
    }

    public function updateName(Request $req)
    {
        if($req->new_name == "")
        {
            return back();
        } else {
            $user = User::where('id', Auth::user()->id)->first();
            $user->name = $req->new_name;
            $user->save();
            return back();
        }       
    }

    public function password()
    {
        return view('password');
    }

    public function change_password(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'currentpassword' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        return $fail(__('Sai mật khẩu hiện tại'));
                    }
                },
                'min:8',
                'max:30'
            ],
            'newpassword' => ['required', 'min:8', 'max:30'],
            'cnewpassword' => ['required', 'same:newpassword']
        ], [
            'currentpassword.required' => 'Nhập mật khẩu hiện tại',
            'currentpassword.min' => 'Mật khẩu hiện tại có ít nhất 8 kí tự',
            'currentpassword.max' => 'Mật khẩu hiện tại có tối đa 30 kí tự',
            'newpassword.required' => 'Nhập mật khẩu mới',
            'newpassword.min' => 'Mật khẩu mới có ít nhất 8 kí tự',
            'newpassword.max' => 'Mật khẩu mới có tối đa 30 kí tự',
            'cnewpassword.required' => 'Vui lòng xác nhận mật khẩu',
            'cnewpassword.min' => 'Mật khẩu mới có ít nhất 8 kí tự',
            'cnewpassword.same' => 'Xác nhận mật khẩu trùng với mật khẩu mới',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $update = User::find(Auth::user()->id)->update(['password' => Hash::make($req->newpassword)]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong. Failed to update password to db']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Your password has been changed successfully']);
            }
        }
    }
}
