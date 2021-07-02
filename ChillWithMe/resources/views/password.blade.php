@extends('layouts.app')

@section('content')
<div class="password-content container-fluid">
    <div class="row d-flex justify-content-center">
        <h1 class="row d-flex justify-content-center">Đổi mật khẩu</h1>
    </div>
    <div class="row d-flex justify-content-center mt-3">
        <form class="col-xl-6 col-lg-6 col-md-8 col-12" id="form-password" method="POST" action="/home/change-password">
            @csrf

            <div class="form-group row">
                <input placeholder="Mật khẩu hiện tại" id="input-current-password" type="text" class="input-current-password " 
                name="currentpassword">
                <div><span class="text-danger error-text currentpassword_error ml-4"></span></div>
            </div>

            <div class="form-group row">
                <input placeholder="Mật khẩu mới" id="input-new-password" type="text" class="input-new-password " 
                name="newpassword">
                <div><span class="text-danger error-text newpassword_error ml-4"></span></div>
            </div>

            <div class="form-group row">
                <input placeholder="Xác nhận mật khẩu" id="input-confirm-new-password" type="text" class="input-confirm-new-password"
                name="cnewpassword">
                <div><span class="text-danger error-text cnewpassword_error ml-4"></span></div>
            </div>

            <div class="form-group row">
                <button id="password-btn" type="submit" class="btn btn-outline-success">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection