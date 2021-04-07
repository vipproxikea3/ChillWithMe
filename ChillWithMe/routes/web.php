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

    // Room
    Route::get('/rooms', [RoomController::class, 'index']);

    // User
    Route::get('/me', [UserController::class, 'index']);

    // Pusher
    // Route::post('/pusher', function () {
    //     $message = 'hello';
    //     $pusher = new Pusher(
    //         env('PUSHER_APP_KEY'),
    //         env('PUSHER_APP_SECRET'),
    //         env('PUSHER_APP_ID'),
    //         [
    //             'cluster' => 'ap1',
    //             'encrypted' => true
    //         ]
    //     );
    //     //channel is auth role and id, ex: user_id_1 or influencer_id1
    //     $pusher->trigger('test-channel', 'test-event', $message);
    //     return 1;
    // });
});
