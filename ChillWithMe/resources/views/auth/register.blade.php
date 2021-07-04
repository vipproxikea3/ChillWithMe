@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <img class="col-xl-3 col-lg-3 col-md-4 col-8 mt-3" src="/img/listening.svg" alt="">
    </div>
    <div class="row d-flex justify-content-center mt-3">
        <form class="col-xl-6 col-lg-6 col-md-8 col-12" id="form-register" method="POST" action="\user-register">
            @csrf

            <div class="form-group row">
                <input placeholder="Họ và tên" id="name" type="text" class="input-register" 
                name="name" value="{{ old('name') }}" autocomplete="name">

                <div><span class="text-danger error-text name_error ml-4"></span></div>
            </div>

            <div class="form-group row">
                <input placeholder="Tên đăng nhập" id="email" type="text" class="input-register"
                name="email" value="{{ old('email') }}" autocomplete="email">
                
                <div><span class="text-danger error-text email_error ml-4"></span></div>
            </div>

            <div class="form-group row">
                <input placeholder="Mật khẩu" id="password" type="password" class="input-register"
                name="password" autocomplete="new-password">

                <div><span class="text-danger error-text password_error ml-4"></span></div>
            </div>

            <div class="form-group row">
                <input placeholder="Xác nhận mật khẩu" id="password-confirm" type="password" class="input-register" 
                name="password_confirmation" autocomplete="new-password">

                <div><span class="text-danger error-text password_confirmation_error ml-4"></span></div>
            </div>

            <div class="form-group row">
                <button id="register-btn" type="submit" class="btn btn-outline-success">
                    Đăng ký
                </button>
            </div>
        </form>
    </div>
    @endsection