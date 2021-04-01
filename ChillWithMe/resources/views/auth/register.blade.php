@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <img class="register-image mt-3" src="/img/listening.svg" alt="">
    </div>
    <div class="row d-flex justify-content-center mt-3">
        <form id="form-register" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
                <input placeholder="Họ và tên" id="name" type="text" class="input-register @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <input placeholder="Tên đăng nhập" id="email" type="email" class="input-register @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <input placeholder="Mật khẩu" id="password" type="password" class="input-register @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <input placeholder="Nhập lại mật khẩu" id="password-confirm" type="password" class="input-register" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-group row">
                <button id="register-btn" type="submit" class="btn btn-outline-success">
                    Đăng ký
                </button>
            </div>
        </form>
    </div>
    @endsection