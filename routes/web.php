<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
use App\User;
use App\Post;
use App\File;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/run', function (){
});
Route::get('/friendships/{id1}/{id2}', 'FriendshipsController@getFriendship');
Route::get('/getFiles/{id}', 'FilesController@getMetaDataFile');
Auth::routes();
Route::post('/api/login', 'UsersController@loginService');
Route::get('/home', 'HomeController@index');
Route::resource('users', 'UsersController');
Route::resource('files', 'FilesController');
Route::resource('posts', 'PostsController');
Route::resource('friendships', 'FriendshipsController');