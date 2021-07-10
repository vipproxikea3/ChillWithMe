<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;
use App\Models\Song;
use App\Models\Room;
use App\Models\Message;
use App\Models\UserJoinRoom;
use Pusher\Pusher;

class RoomController extends Controller
{
    public function index(Request $req)
    {
        $idRoom = $req->idRoom;
        if (!isset($idRoom) || $idRoom == '')
            return redirect('404');
        $room = Room::where('idRoom', $idRoom)->first();
        $roomMaster = User::find($idRoom);
        if (!isset($roomMaster))
            return redirect('404');

        if (Auth::user()->id == $roomMaster->id) {
            if (!isset($room)) {
                $newRoom = new Room;
                $newRoom->idRoom = $idRoom;
                $newRoom->playing = false;
                $newRoom->save();
            }

            $room = Room::where('idRoom', $idRoom)->update([
                'playing' => 0
            ]);

            Song::where('idRoom', $idRoom)->delete();
            Message::where('idRoom', $idRoom)->delete();
        } else {
            if (!isset($room)) {
                return redirect('404');
            } else {
                if ($roomMaster->idRoom != $idRoom) {
                    return redirect('404');
                } else {
                    if ($room->password != $req->passRoom)
                        return back();
                }
            }
        }

        $user = User::find(Auth::user()->id);
        $user->idRoom = $req->idRoom;
        $user->save();

        $userJoinRooms = UserJoinRoom::where([
            ["idUser", Auth::user()->id],
            ["idRoom", $req->idRoom]
        ])->first();

        if (!isset($userJoinRooms)) {
            $userJoinRoom = new UserJoinRoom();
            $userJoinRoom->idUser = Auth::user()->id;
            $userJoinRoom->idRoom = $req->idRoom;
            $userJoinRoom->save();
        }

        $songs = Song::where('idRoom', $idRoom)->get();

        $messages = Message::where('idRoom', $idRoom)->orderByDesc('id')->take(100)->get();
        $messages = $messages->reverse();

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

        return view('room', [
            'user' => $user,
            'idRoom' => $roomMaster->id,
            'masterRoom' => $roomMaster->name,
            'songs' => $songs,
            'messages' => $messages,
        ]);
    }

    public function sendMessages(Request $req)
    {
        $newMessage = new Message;
        $newMessage->idRoom = $req->idRoom;
        $newMessage->idUser = $req->idUser;
        $newMessage->userName = User::find($req->idUser)->name;
        $newMessage->message = $req->message;
        $newMessage->save();

        $messages = Message::where('idRoom', $req->idRoom)->orderByDesc('id')->take(100)->get();


        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        );
        $pusher->trigger('room', 'messages', $messages);
        return $req;
    }

    public function getOnlineMember(Request $req)
    {
        $idRoom = $req->idRoom;
        if (!isset($idRoom) || $idRoom == '')
            return redirect('404');
        $members = User::where('idRoom', $idRoom)->get();
        return $members;
    }

    public function kickMember(Request $req)
    {
        $idRoom = $req->idRoom;
        $idMember = $req->idMember;
        if (!isset($idRoom) || $idRoom == '')
            return redirect('404');
        if (!isset($idMember) || $idMember == '')
            return redirect('404');
        $user = User::where('id', $idMember)->first();
        if (isset($user) && $user->idRoom == $idRoom) {
            $user->idRoom = NULL;
        }
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        );
        $pusher->trigger('room', 'kick', ['idRoom' => $idRoom, 'idUser' => $idMember]);
        return 'success';
    }
}
