<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', 'ProductController@home');

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('contacts', 'ContactController');

Route::resource('categories', 'CategoryController');

Route::resource('products', 'ProductController')->middleware('auth');

Route::get('/products/deleteImage/{id}', 'ProductController@deleteImage')->middleware('auth');

Route::post('/products/upload', 'ProductController@upload');
