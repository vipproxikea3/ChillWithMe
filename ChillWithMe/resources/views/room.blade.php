@extends('layouts.app')

@section('content')
<div class="room-content container-fluid">
    <div class="row">
        <span class="col-lg-3 col-md-4 col-12"><strong>Chủ phòng: </strong>{{$masterRoom}}</span>
        <span class="col-lg-3 col-md-4 col-12" id="idRoom" data-idroom="{{ $user->idRoom }}"><strong>Mã phòng: </strong>{{$idRoom}}</span>
    </div>
    <div class="row mt-5">
        <div class="main-left col d-none d-lg-block d-xl-block">
            <div class="row">
                <form id="form-search">
                    <input placeholder="Tìm kiếm" type="text" name="keyword" id="input-search">
                </form>
            </div>
            <div class="row result-list mt-5">
                <div id="result-list" class="col-12">
                </div>
            </div>
        </div>
        <div class="main-right col d-lg-block d-xl-block">
            <div style="display: none;" id="player"></div>
            <marquee id="playing-title" class="row playing-title" direction="left"></marquee>
            <div class="row d-flex justify-content-center my-3">
                <img id="playing-disk" class="playing-disk" alt="">
            </div>
            <div class="row d-flex justify-content-center my-3">
                <button onclick="nextSong()" style="border: none;" type="button" class="btn btn-outline-success">
                    <i class="fa fa-step-forward" aria-hidden="true"></i>
                </button>
            </div>
            <div id="queue" class="queue">
                @foreach ($songs as $song)
                <div class="row queue-item my-3">
                    <div class="queue-item-title d-flex flex-column justify-content-center">
                        <span>{{$song->title}}
                        </span>
                    </div>
                    <div class="queue-item-play">
                        <button style="border: none;" type="button" class="btn btn-outline-success">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Button switch screen -->
    <button id="switch-btn" type="button" onclick="switchScreen()" class="
                            d-block d-lg-none d-xl-none
                            switch-screen-btn
                            btn btn-outline-success btn-lg
                        ">
        <i class="fa fa-search" aria-hidden="true"></i>
    </button>
    <!-- Button trigger modal -->
    <button id="showChatBox" type="button" onclick="showChatBox()" class="chat-box-btn btn btn-outline-success btn-lg" data-toggle="modal" data-target="#chatBoxModal">
        <i class="fa fa-comments" aria-hidden="true"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="chatBoxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="box-chat modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trò chuyện</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="box-chat-body" class="box-chat-body modal-body">
                    @foreach ($messages as $message)
                    <p><strong>{{$message->userName}}: </strong>{{$message->message}}</p>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <form id="form-message" class="form-message" action="">
                        <div class="input-group">
                            <input name="message" id="input-message" type="text" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection