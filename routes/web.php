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
// Route::get('posts', 'PostController@index')->name('posts.index');
// Route::get('posts/create', 'PostController@create')->name('posts.create');
// Route::post('posts', 'PostController@store')->name('posts.store');
Route::get('create_title', 'PostController@create_title')->name('posts.create_title');
Route::post('store_title', 'PostController@store_title')->name('posts.store_title');
Route::post('store_thumnail', 'PostController@store_thumnail')->name('posts.store_thumnail');
Route::get('createPost_tags', 'PostController@create_tags')->name('posts.create_tags');
Route::post('posts/store_tags', 'PostController@store_tags')->name('posts.store_tags');
Route::get('createPost_confirm', 'PostController@show_confirm')->name('posts.confirm');
Route::get('release', 'PostController@release_post')->name('posts.release');
Route::get('draft', 'PostController@draft_post')->name('posts.draft');
