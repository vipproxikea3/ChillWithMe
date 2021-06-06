@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <img class="col-xl-4 col-lg-4 col-md-6 col-10 mt-3" src="/img/compose_music.svg" alt="">
    </div>
    <div class="row d-flex justify-content-center">
        <form class="col-xl-6 col-lg-6 col-md-8 col-12" id="form-inputIdRoom" action="/rooms" method="GET">
            <div class="form-group">
                <input id="inputIdRoom" type="number" class="form-control" placeholder="Mã phòng" required>
            </div>
        </form>
    </div>
    <div class="modal fade" id="inputIdRoomModal" tabindex="-1" role="dialog" aria-labelledby="inputIdRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputIdRoomModalLabel">Nhập mật khẩu phòng</h5>
                </div>
                <div class="modal-body">
                    <form id="final-form-inputIdRoom" action="/rooms" method="POST">
                        @csrf
                        <div class="form-group">
                            <input id="final-inputIdRoom" type="number" class="form-control d-none" name="idRoom" placeholder="Mã phòng" required>
                        </div>
                        <div class="form-group">
                            <input id="final-inputPassRoom" type="number" class="form-control" name="passRoom" placeholder="Mật khẩu phòng">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="getRoom-btn" type="button" class="btn btn-outline-success">Vào phòng</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection