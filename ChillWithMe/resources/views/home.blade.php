@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form action="/rooms" method="GET">
            <input style="display: none;" type="text" name="idRoom" value="{{Auth::user()->id}}">
            <button type="submit" id="myRoom" class="ml-3 btn btn-outline-success">
                <i class="fa fa-arrow-right mr-3" aria-hidden="true"></i>
                <span>Phòng của tôi</span>
            </button>
        </form>

    </div>
    <div class="row card-profile p-5 mt-5">
        <div class="col">
            <div class="row justify-content-center my-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="profile-field py-1 px-3">Họ và tên</div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <span>{{Auth::user()->name}}</span>
                </div>
            </div>
            <div class="row justify-content-center my-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="profile-field py-1 px-3">Tên đăng nhập</div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <span>{{Auth::user()->email}}</span>
                </div>
            </div>
            <div class="row justify-content-center my-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="profile-field py-1 px-3">Mã phòng</div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <span>{{Auth::user()->idRoom}}</span>
                </div>
            </div>
            <div class="row justify-content-center my-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="profile-field py-1 px-3">Mật khẩu</div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div><a href="">Đổi mật khẩu</a></div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection