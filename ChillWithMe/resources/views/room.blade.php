@extends('layouts.app')

@section('content')
<div class="room-content container-fluid">
    <div class="row d-flex">
        <span class="mr-5"><strong>Chủ phòng: </strong>{{$masterRoom}}</span>
        <span><strong>Mã phòng: </strong>{{$idRoom}}</span>
    </div>
    <div class="row mt-5">
        <div class="main-left col-7">
            <div class="row">
                <form id="form-search">
                    <input placeholder="Tìm kiếm bằng youtube" type="text" name="keyword" id="input-search">
                </form>
            </div>
            <div class="row result-list mt-5">
                <div id="result-list" class="col-12">
                    <!-- <div class="row p-2 result-item">
                        <img class="result-item-thumbnail" src="http://i3.ytimg.com/vi/erLk59H86ww/hqdefault.jpg" alt="">
                        <div class="result-item-info pl-3">
                            <div class="py-1 result-item-info-title">
                                <span class="result-item-info-title-text">SGB vs. FL | GLX vs. SE (Bo3) - VCS Mùa Xuân 2021 - W9D2</span>
                            </div>
                            <div class="py-1 result-item-info-channel">
                                VETV7 ESPORTS
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="main-right col-5">
            <marquee class="row playing-title" direction="left"></marquee>
            <div class="row d-flex justify-content-center my-3">
                <img class="playing-disk" alt="">
            </div>
            <div class="row d-flex justify-content-center my-3">
                <button style="border: none;" type="button" class="btn btn-outline-success">
                    <i class="fa fa-step-forward" aria-hidden="true"></i>
                </button>
            </div>
            <div id="queue" class="queue">
                @foreach ($songs as $song)
                <div class="row queue-item my-3 px-5">
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
</div>
@endsection