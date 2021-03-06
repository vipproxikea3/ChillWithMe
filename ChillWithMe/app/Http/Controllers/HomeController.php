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
                        return $fail(__('Sai m???t kh???u hi???n t???i'));
                    }
                },
                'min:8',
                'max:30'
            ],
            'newpassword' => ['required', 'min:8', 'max:30'],
            'cnewpassword' => ['required', 'same:newpassword']
        ], [
            'currentpassword.required' => 'Nh???p m???t kh???u hi???n t???i',
            'currentpassword.min' => 'M???t kh???u hi???n t???i c?? ??t nh???t 8 k?? t???',
            'currentpassword.max' => 'M???t kh???u hi???n t???i c?? t???i ??a 30 k?? t???',
            'newpassword.required' => 'Nh???p m???t kh???u m???i',
            'newpassword.min' => 'M???t kh???u m???i c?? ??t nh???t 8 k?? t???',
            'newpassword.max' => 'M???t kh???u m???i c?? t???i ??a 30 k?? t???',
            'cnewpassword.required' => 'Vui l??ng x??c nh???n m???t kh???u',
            'cnewpassword.min' => 'M???t kh???u m???i c?? ??t nh???t 8 k?? t???',
            'cnewpassword.same' => 'X??c nh???n m???t kh???u tr??ng v???i m???t kh???u m???i',
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
