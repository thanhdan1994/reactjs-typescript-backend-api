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
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'administrator', 'as' => 'admin.'], function () {
        Route::namespace('Admin')->group(function () {
            Route::get('/', 'DashboardController@index')->name('dashboard');
            Route::resource('categories', 'CategoryController');
            Route::resource('brands', 'BrandController');
            Route::resource('posts', 'PostController');
            Route::resource('places', 'PlaceController');
            Route::resource('products', 'ProductController');
            Route::resource('users', 'UserController');
            Route::resource('medias', 'MediaController');
        });
    });
});

Auth::routes();

Route::get('/', function () { return view('index'); });
Route::get('list-posts.html', function () { return view('index'); });
Route::get('product/{id}', function () { return view('index'); });
Route::get('post/{id}', function () { return view('index'); });
Route::get('place/{id}', function () { return view('index'); });
Route::get('list-places.html', function () { return view('index'); });
Route::get('list-products.html', function () { return view('index'); });
