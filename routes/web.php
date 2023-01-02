<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\TwoFaCheck;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
//friend

Route::get('/add/{id}','App\Http\Controllers\FriendsController@add')->name('add');
Route::get('/cancelfriend/{id}','App\Http\Controllers\FriendsController@cancelRequestToFriend')->name('cancelRequestToFriend');
Route::get('/cancelsendrequest/{id}','App\Http\Controllers\FriendsController@cancelSendRequestToFriend')->name('cancelSendRequestToFriend');
Route::get('/deleteFriend/{id}','App\Http\Controllers\FriendsController@deleteFriend')->name('deleteFriend');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/2fa','App\Http\Controllers\FaController@index');
Route::group(['prefix'=>'chat'], function(){
    Route::get('/messages', 'App\Http\Controllers\ChatController@chats');
    Route::get('/{id?}', 'App\Http\Controllers\ChatController@index');
    Route::get('/get/{id}', 'App\Http\Controllers\ChatController@get');
    Route::post('/store/{id}/{chat_id}', 'App\Http\Controllers\ChatController@send')->middleware(['can:avaliable_message']);
    Route::post('/file/{id?}', 'App\Http\Controllers\ChatController@sendFile')->name('fileSend');
    Route::get('/donwload/{file}', 'App\Http\Controllers\ChatController@downloadFile')->name('filesave');
})->middleware(['auth','TwoFaCheck']);

Route::group(['prefix'=>'profile'], function(){
    Route::get('/','App\Http\Controllers\ProfileeController@index');
    Route::get('/accept/{id}','App\Http\Controllers\ProfileeController@accept')->name('accept');
})->middleware('auth');

require __DIR__.'/auth.php';

Auth::routes();
route::post('/logoutall', function (){
    \Illuminate\Support\Facades\Auth::logoutOtherDevices(request()->input('password'));
})->name('logoutall');

Route::get('/login2', function (){
    if (auth()->user()){
        return redirect('/profile');
    }
    return view('login2');
});
Route::get('/logout2', 'App\Http\Controllers\Auth2\LoginController@logout')->name('logout');
Route::get('/2fa', function(){
    return view('fa');
});
Route::post('/2faotp', 'App\Http\Controllers\Auth2\LoginController@vetifyOTP')->name('vetifyOTP');

Route::post('/login2','App\Http\Controllers\Auth2\LoginController@login')->name('authenticate');

Route::post('/search', 'App\Http\Controllers\SearchController@index')->name('search');

Route::get('/friends','App\Http\Controllers\FriendsController@friends')->name('friends');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/payment/create', 'App\Http\Controllers\PaymentController@create')->name('payment.create');
Route::match(['GET','POST'],'/payment/callback',[\App\Http\Controllers\PaymentController::class])->name('payment.callback');
Route::get('/payments','App\Http\Controllers\PaymentController@index')->name('payment.index');
Route::get('/versta', function (){
    return view('verstka');
});
