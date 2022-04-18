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
Route::get('create_title', 'PostController@create_title')->name('posts.create_title');
Route::post('store_title', 'PostController@store_title')->name('posts.store_title');
Route::post('store_thumnail', 'PostController@store_thumnail')->name('posts.store_thumnail');
Route::get('createPost_tags', 'PostController@create_tags')->name('posts.create_tags');
Route::post('posts/store_tags', 'PostController@store_tags')->name('posts.store_tags');
Route::get('createPost_confirm', 'PostController@show_confirm')->name('posts.confirm');
Route::get('release', 'PostController@release_post')->name('posts.release');
Route::get('draft', 'PostController@draft_post')->name('posts.draft');
Route::get('save_post_show', 'PostController@save_post_show')->name('posts.save_post_show');

Route::resource('follow', 'FollowController');
Route::post('user_search', 'FollowController@user_search')->name('follow.user_search');
Route::post('user_page', 'FollowController@user_page')->name('follow.user_page');
Route::get('user_page_show', 'FollowController@user_page_show')->name('follow.user_page_show');
Route::post('user_follow', 'FollowController@user_follow')->name('follow.user_follow');
Route::post('follow_remove', 'FollowController@follow_remove')->name('follow.follow_remove');

Route::resource('settingUser', 'SettingUserController');
Route::post('user_name_change', 'SettingUserController@user_name_change')->name('settingUser.user_name_change');
Route::post('user_email_change', 'SettingUserController@user_email_change')->name('settingUser.user_email_change');
Route::post('user_password_change', 'SettingUserController@user_password_change')->name('settingUser.user_password_change');
Route::post('user_icon_change', 'SettingUserController@user_icon_change')->name('settingUser.user_icon_change');

Route::resource('settingFavoriteTag', 'SettingFavoriteTagControlloer');
Route::post('settingFavoriteTag/store_tags', 'SettingFavoriteTagControlloer@store_tags')->name('settingFavoriteTag.store_tags');
Route::post('settingFavoriteTag/redirect', 'SettingFavoriteTagControlloer@redirect')->name('settingFavoriteTag.redirect');

Route::get('settingQuestionReceive', 'SettingQuestionReceiveController@index')->name('settingQuestionReceive.index');
Route::post('store_questionReceive', 'SettingQuestionReceiveController@store_questionReceive')->name('settingQuestionReceive.store_questionReceive');

Route::get('settingNotice', 'SettingNoticeController@index')->name('settingNotice.index');
Route::post('store_notice_users', 'SettingNoticeController@store_notice_users')->name('settingNotice.store_notice_users');
Route::post('settingNoticeTag/store_questionTags', 'SettingNoticeController@store_questionTags')->name('settingNotice.store_questionTags');
Route::post('settingNoticeTag/store_postTags', 'SettingNoticeController@store_postTags')->name('settingNotice.store_postTags');
Route::post('settingNoticeTag/redirect', 'SettingNoticeController@redirect')->name('settingNoticeTag.redirect');

Route::get('timeline', 'TimelineController@index')->name('timeline.index');
Route::get('users_post', 'TimelineController@users_post')->name('timeline.users_post');
Route::post('post_detail', 'TimelineController@post_detail')->name('timeline.post_detail');

Route::get('post_search_result', 'SearchController@post_search_result')->name('search.post_search_result');
Route::post('post_search', 'SearchController@post_search')->name('search.post_search');
Route::post('search_tag_store', 'SearchController@search_tag_store')->name('search.search_tag_store');

Route::post('good_store', 'GoodController@good_store')->name('good_store');

Route::post('save_store', 'SaveController@save_store')->name('save_store');
