@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <img class="welcome-image mt-3" src="/img/compose_music.svg" alt="">
    </div>
    <div class="row d-flex justify-content-center">
        <form id="form-inputIdRoom" action="/rooms" method="GET">
            <div class="form-group">
                <input id="inputIdRoom" type="text" class="form-control" name="idRoom" placeholder="Mã phòng" required>
            </div>
        </form>
    </div>
</div>
@endsection