<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;

class RoomController extends Controller
{
    public function index(Request $req)
    {
        $idRoom = $req->idRoom;
        $room = User::find($idRoom);
        if (!isset($room))
            return redirect('404');
        $user = User::find(Auth::user()->id);
        $user->idRoom = $req->idRoom;
        $user->save();
        return view('room', []);
    }
}
