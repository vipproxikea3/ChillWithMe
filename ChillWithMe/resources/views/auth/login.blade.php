@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <img class="login-image mt-3" src="/img/happy_music.svg" alt="">
    </div>
    <div class="row d-flex justify-content-center mt-3">
        <form id="form-login" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row">
                <input placeholder="Tên đăng nhập" id="email" type="email" class="input-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <input placeholder="Mật khẩu" id="password" type="password" class="input-login @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group row">
                <button id="login-btn" type="submit" class="btn btn-outline-success">
                    Đăng nhập
                </button>
            </div>
        </form>
    </div>
</div>
@endsection