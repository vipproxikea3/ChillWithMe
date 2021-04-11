<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SongController;

use App\Events\TestEvent;
use Pusher\Pusher;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['middleware' => 'auth'])->group(function () {

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Song
    Route::post('/songs/queue', [SongController::class, 'addQueue']);
    Route::post('/songs/play', [SongController::class, 'playSong']);
    Route::post('/songs/next', [SongController::class, 'nextSong']);

    // Room
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::post('/rooms/messages', [RoomController::class, 'sendMessages']);

    // User
    Route::get('/me', [UserController::class, 'index']);
});
