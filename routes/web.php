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

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::resource('posts', 'PostController');
Route::resource('users', 'UserController')->only(['update', 'edit', 'show']);

Route::get('/posts/tag/{tag}', 'PostTagController@index')->name('posts.tag.index');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/secret', 'HomeController@secret')->name('secret')->middleware('can:view.secret');

Route::resource('posts.comments', 'PostCommentController')->only('store');
