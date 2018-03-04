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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/chat/{productid}', 'Chat\ChatController@index')->name('chat');
Route::get('/chat/{productid}/fetch', 'Chat\ChatController@fetchMessage')->name('chat.fetch');
Route::post('/chat/{productid}/send', 'Chat\ChatController@sendMessage')->name('chat.send');


Route::get('/opchat/{productid}/{userid}', 'Chat\OPChatController@index')->name('opchat');
Route::get('/opchat/{productid}/{userid}/fetch', 'Chat\OPChatController@fetchMessage')->name('opchat.fetch');
Route::post('/opchat/{productid}/{userid}/send', 'Chat\OPChatController@sendMessage')->name('opchat.send');


