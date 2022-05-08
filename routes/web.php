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
    return view('logins.index');
});



// Route::resource('registers', 'RegisterController');

if (env('APP_ENV') === 'local') {
    URL::forceScheme('https');
}

Route::get('registers', 'RegisterController@index')->name('registers.index');
Route::post('registers/confirm', 'RegisterController@confirm')->name('registers.confirm');
Route::post('registers/store', 'RegisterController@register_store')->name('registers.store');
Route::get('registers/complete', 'RegisterController@register_show')->name('registers.show');

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
Route::post('post_delete', 'PostController@post_delete')->name('posts.post_delete');
Route::get('post_deleted', 'PostController@post_deleted')->name('posts.post_deleted');
Route::get('draft_post', 'PostController@show_draft_post')->name('posts.draft_post');
Route::post('post_release_flag_chnge', 'PostController@release_flag_chnge')->name('post_release_flag_chnge');

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
Route::get('question_search_result', 'SearchController@question_search_result')->name('search.question_search_result');
Route::post('question_search', 'SearchController@question_search')->name('search.question_search');
Route::post('question_tag_store', 'SearchController@question_tag_store')->name('search.question_tag_store');

Route::post('good_store', 'GoodController@good_store')->name('good_store');

Route::post('save_store', 'SaveController@save_store')->name('save_store');

Route::post('comment_store', 'CommentController@comment_store')->name('comment_store');
Route::post('reply_store', 'CommentController@reply_store')->name('reply_store');
Route::post('answer_comment_store', 'CommentController@answer_comment_store')->name('answer_comment_store');
Route::post('answer_reply_store', 'CommentController@answer_reply_store')->name('answer_reply_store');

Route::resource('question', 'QuestionController');
Route::get('create_tags', 'QuestionController@create_tags')->name('question.create_tags');
Route::post('question/store_tags', 'QuestionController@store_tags')->name('question.store_tags');
Route::post('question/store_users', 'QuestionController@store_users')->name('question.store_users');
Route::post('question/redirect', 'QuestionController@redirect')->name('question.redirect');
Route::get('question_confirm', 'QuestionController@confirm')->name('question.confirm');
Route::get('release_question', 'QuestionController@release_question')->name('question.release');
Route::get('draft_question', 'QuestionController@draft_question')->name('question.draft');
Route::get('question_list_show', 'QuestionController@question_list_show')->name('question_list_show');
Route::post('question_detail', 'QuestionController@question_detail')->name('question_detail');
Route::get('users_question', 'QuestionController@users_question')->name('question.users_question');
Route::post('question_delete', 'QuestionController@question_delete')->name('question.question_delete');
Route::get('question_deleted', 'QuestionController@question_deleted')->name('question.question_deleted');
Route::get('show_draft_question', 'QuestionController@show_draft_question')->name('question.draft_question');
Route::post('question_release_flag_chnge', 'QuestionController@release_flag_chnge')->name('question_release_flag_chnge');

Route::resource('answer', 'AnswerController');
Route::post('create_answer', 'AnswerController@create_answer')->name('create_answer');
Route::get('answer_confirm', 'AnswerController@confirm')->name('answer.confirm');
Route::get('release_answer', 'AnswerController@release_answer')->name('answer.release');
Route::get('draft_answer', 'AnswerController@draft_answer')->name('answer.draft');
Route::get('question_content', 'AnswerController@question_content')->name('answer.question_content');
Route::post('answer_detail', 'AnswerController@answer_detail')->name('answer_detail');
Route::get('users_answer', 'AnswerController@users_answer')->name('answer.users_answer');
Route::post('bestAnswer_select', 'AnswerController@bestAnswer_select')->name('bestAnswer_select');
Route::post('answer_delete', 'AnswerController@answer_delete')->name('answer.answer_delete');
Route::get('answer_deleted', 'AnswerController@answer_deleted')->name('answer.answer_deleted');
Route::post('answer_release_flag_chnge', 'AnswerController@release_flag_chnge')->name('answer_release_flag_chnge');