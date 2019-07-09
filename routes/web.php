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
Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view('auth/login');
});
Route::get('register', function () {
    return view('auth/register');
});
Route::get('single-blog-post', function () {
    return view('single-blog-post');
});
Route::get('microblog', function () {
    return view('microblog', 'HomeController@microblog');
});
Route::get('posts', function () {
    return view('posts');
});
Route::get('settings', function (){
    return view('settings');
});

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('login', 'LoginController@do')->name('login');

Route::prefix('{username}')->group(function () {

  //Auth::routes();
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/timeline', 'HomeController@timeline');
});
Route::post('/logout', "AuthController@logout")->name('logout');
