<?php

//use App\Http\Middleware\CheckIsAdminSMZ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', 'Api\AuthController@login');
Route::post('/logout', 'Api\AuthController@logout')->middleware('auth:api');
Route::get('/auth', 'Api\AuthController@auth')->middleware('auth:api');

Route::resource('/users', 'Api\UserController')->middleware('auth:api');
Route::put('/user-activated/{user}', 'Api\UserController@updateAtivated')->middleware('auth:api');
Route::resource('/roles', 'Api\RoleController')->middleware('auth:api');
Route::resource('/services', 'Api\ServiceController')->middleware('auth:api');
Route::resource('/calls', 'Api\CallController')->middleware('auth:api');
Route::put('/call-solver/{id}', 'Api\CallController@directSolver')->middleware('auth:api');
Route::get('/call-solver/{id}', 'Api\CallController@showSolver')->middleware('auth:api');
Route::resource('/images', 'Api\ImageController')->middleware('auth:api');
Route::post('/images/{id}', 'Api\ImageController@storeImageInCall')->middleware('auth:api');
Route::resource('/responses', 'Api\ResponseController')->middleware('auth:api');

Route::prefix('home')->middleware('auth:api')->group(function () {
    Route::get('/details-calls-solver/{User}', 'Api\HomeController@detailsCallsPerSolver');
    Route::get('/admin/status-calls', 'Api\HomeController@statusAllCalls');
    Route::get('/admin/status-calls-solvers', 'Api\HomeController@callsUserSolver');
    Route::get('/status-calls-auth', 'Api\HomeController@callsUserAuth');
});

Route::prefix('notificable')->middleware('auth:api')->group(function () {
    Route::get('calls', 'Api\CallNotifyController@index');
    Route::put('all', 'Api\CallNotifyController@markOnReadAll');
    Route::put('{id}', 'Api\CallNotifyController@markOnRead');
});

Route::get('/profile', 'Api\ProfileController@edit')->middleware('auth:api');
Route::post('/profile', 'Api\ProfileController@storagePhoto')->middleware('auth:api');
Route::put('/profile/{id}', 'Api\ProfileController@update')->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::get('chat-users', 'Api\MessageController@getUsersOfChat');
    Route::get('chat-messages', 'Api\MessageController@getMessages');
    Route::post('chat-send-message', 'Api\MessageController@sendMessage');
});

Broadcast::routes(['middleware' => 'auth:api']);
