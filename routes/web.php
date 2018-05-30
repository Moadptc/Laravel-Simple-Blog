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

use Illuminate\Support\Facades\Route;

// landing page
Route::get('/','PagesController@index');

// pages
Route::get('/about','PagesController@about');
Route::get('/contact','PagesController@contact')->name('ctc');
Route::post('/dosend','PagesController@dosend');

// posts
Route::resource('posts','PostsController');

// Tags
Route::resource('tags','TagsController')->only(['show']);

// comments
Route::post('/comments/{slug}','CommentsController@store')
    ->name('comments.store');  // name for pass it in route inside action

// auth
Auth::routes();
Route::get('user/verify/{token}' , 'Auth\RegisterController@verifyEmail');

Route::get('/home', 'HomeController@index')->name('home');
