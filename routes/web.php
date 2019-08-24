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

/**
 * Public Routes
 */
Route::get('/', function () {
   return view('welcome');
});
Route::get('loader', function () {
   return view('preloader');
});
Route::get('explore', function () {
   return view('explore');
});
Route::get('under-construction', 'HomeController@construction')->name('under-construction');

Route::get('explore', function () {
   return view('explore');
});


/**
 * Auth Routes
 *
 */
Route::get('login', function () {
   return view('auth/login');
});
Route::get('register', function () {
   return view('auth/register');
});

Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('login', 'LoginController@do')->name('login');


/**
 * Protected Routes
 */
Route::get('subscribe', function () {
   return view('subscribe');
});


Route::post('save-post', 'Users\PostsController@savePost');
Route::post('save-subscription', 'Users\SubscriptionController@saveSubscriptionEmail');


Route::prefix('{username}')->group(function () {

   //auth
   Route::get('/logout', "Auth\LoginController@logout");


   //general
   Route::get('/', 'pageController@index');
   Route::get('/home', 'pageController@index');

   Route::get('/contact', 'pageController@contact');
   Route::post('/unfollow', 'ExtRssController@unfollow');
   Route::get('/subscribe', 'HomeController@subscribe');
   Route::get('/following', 'pageController@following')->name('following');
   Route::get('/followers', 'pageController@followers')->name('followers');


   //meta
   Route::post('/send-mail', 'Users\MailController@sendEmail');
   Route::post('/addrss', 'ExtRssController@addRss');
   Route::post('/extrss', 'ExtRssController@addExtRss');



   //posts
   Route::get('/post/{postTitle}', 'Users\PostsController@singlePostPage');
   Route::get('/posts', 'Users\PostsController@posts');
   Route::post('/publish', 'Users\PostsController@publish');


   //thoughts
   Route::get('/thoughts', 'pageController@thoughts');


   //settings

   Route::post('/update-contact-details', 'Users\SettingsController@updateContactDetails');
   Route::post('/save_settings', 'Users\SettingsController@saveSettings');
   Route::get('/settings', 'Users\SettingsController@settings');

});
