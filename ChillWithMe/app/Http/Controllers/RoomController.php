<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;

class RoomController extends Controller
{
    public function index($id)
    {
        $user = User::find(Auth::user()->id);
        $user->idRoom = $id;
        $user->save();
        return $id;
    }
}
