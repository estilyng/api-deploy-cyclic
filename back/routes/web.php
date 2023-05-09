<?php

use App\Models\Call;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
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

// Route::get('/', function () {
//     // $call = Call::orderBy('created_at', 'desc')->first();
//     // $image = $call->images[0]->path;
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Route::prefix('api/notificable')->middleware('auth')->group(function () {
//     Route::get('calls', 'Api\CallNotifyController@index');
//     Route::put('/{id}', 'Api\CallNotifyController@markOnRead');
//     Route::put('/all', 'Api\CallNotifyController@allMarkOnRead');
// });

// Route::get('/', 'SiteController@home')->name('site');
