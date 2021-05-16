@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <img class="col-xl-4 col-lg-4 col-md-6 col-10 mt-3" src="/img/compose_music.svg" alt="">
    </div>
    <div class="row d-flex justify-content-center">
        <form class="col-xl-6 col-lg-6 col-md-8 col-12" id="form-inputIdRoom" action="/rooms" method="GET">
            <div class="form-group">
                <input id="inputIdRoom" type="text" class="form-control" name="idRoom" placeholder="Mã phòng" required>
            </div>
        </form>
    </div>
</div>
@endsection