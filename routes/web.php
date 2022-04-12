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



Route::resource('registers', 'RegisterController');

if (env('APP_ENV') === 'local') {
    URL::forceScheme('https');
}

Route::post('registers/confirm', 'RegisterController@confirm')->name('registers.confirm');

Route::resource('logins', 'LoginController');

Route::post('logins/auth', 'LoginController@auth')->name('logins.auth');

Route::get('logout', 'LoginController@logout')->name('logout');

Route::resource('posts', 'PostController');
Route::get('posts/create_title', 'PostController@create_title')->name('posts.create_title');
Route::post('store_title', 'PostController@store_title')->name('posts.store_title');
Route::post('store_thumnail', 'PostController@store_thumnail')->name('posts.store_thumnail');
Route::get('posts/tag_create', 'PostController@tag_create')->name('posts.tag_create');
