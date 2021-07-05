@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <form action="/rooms" method="POST">
            @csrf
            <input style="display: none;" type="text" name="idRoom" value="{{Auth::user()->id}}">
            <button type="submit" id="myRoom" class="btn btn-outline-success">
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
                    <span>{{$room->id}}</span>
                </div>
            </div>
            <div class="row justify-content-center my-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="profile-field py-1 px-3">Mật khẩu phòng</div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <span>{{$room->password}}</span>
                    <button class="border-0 btn btn-outline-success" data-toggle="modal" data-target="#editRoomPassModal">
                        <i class="fa fa-wrench" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <div class="row justify-content-center my-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="profile-field py-1 px-3">Mật khẩu</div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div><a href="/password">Đổi mật khẩu</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editRoomPassModal" tabindex="-1" role="dialog" aria-labelledby="editRoomPassModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đổi mật khẩu phòng</h5>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateRoomPass-form" action="/home/pass" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Mật khẩu mới</label>
                            <input type="number" class="form-control" name="newRoomPass" placeholder="Chỉ nhập số">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="updateRoomPass-btn" class="btn btn-outline-success"><i class="fa fa-check" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection