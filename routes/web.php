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

//ブログ一覧
Route::get('/', 'BlogController@showList')->name('blogs');

//登録画面
Route::get('blog/create', 'BlogController@showCreate')->name('create');

//ブログ登録
Route::post('blog/store', 'BlogController@exeStore')->name('store');

//ブログ詳細
Route::get('blog/{id}', 'BlogController@showDetail')->name('show');


Route::get('blog/edit/{id}', 'BlogController@showEdit')->name('edit');

Route::post('blog/update', 'BlogController@exeUpdate')->name('update');


Route::post('blog/delete/{id}', 'BlogController@exeDelete')->name('delete');
