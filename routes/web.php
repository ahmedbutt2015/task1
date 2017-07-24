<?php

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

Route::group(['middleware' => ['guest']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/admin', function () {
        return view('admin.login');
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', function () {
        return view('profile')
            ->with('users', \App\User::where('role_id', 2)->get());
    });
    Route::get('/logout', 'AuthenticationController@logout');
    Route::get('/delete/user/{id}', 'AuthenticationController@delete');
    Route::post('/edit/user', 'AuthenticationController@edit');
});
Route::post('/login', 'AuthenticationController@login');
Route::post('/register', 'AuthenticationController@register');
