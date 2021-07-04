<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SongController;

use App\Models\User;

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

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/user-login', [LoginController::class, 'authenticate']);

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/user-register', [RegisterController::class, 'authenticate']);

Route::get('/', function () {
    if (Auth::user() != null) {
        $user = User::where('id', Auth::user()->id)->first();
        $user->idRoom = NULL;
        $user->save();
    }
    return view('welcome');
});

Route::middleware(['middleware' => 'auth'])->group(function () {

    // Home
    Route::post('/home/pass', [HomeController::class, 'updatePass']);
    Route::get('/password', [HomeController::class, 'password']);
    Route::post('/home/change-password', [HomeController::class, 'change_password']);
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Song
    Route::post('/songs/queue', [SongController::class, 'addQueue']);
    Route::post('/songs/play', [SongController::class, 'playSong']);
    Route::post('/songs/next', [SongController::class, 'nextSong']);

    // Room
    Route::post('/rooms', [RoomController::class, 'index']);
    Route::post('/rooms/messages', [RoomController::class, 'sendMessages']);

    // User
    Route::get('/me', [UserController::class, 'index']);
});
