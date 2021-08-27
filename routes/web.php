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
            Route::resource('products', 'ProductController');

            Route::get('products/{product_id}/variants/create', 'VariantController@create')->name('variants.create');
            Route::get('products/{product_id}/variants/{id}/edit', 'VariantController@edit')->name('variants.edit');
            Route::put('products/{product_id}/variants/{id}', 'VariantController@update')->name('variants.update');
            Route::delete('products/{product_id}/variants/{id}', 'VariantController@destroy')->name('variants.destroy');
            Route::post('products/{product_id}/variants', 'VariantController@store')->name('variants.store');

            Route::resource('users', 'UserController');
            Route::resource('medias', 'MediaController');
            Route::post('upload-image', 'ImageController@upload')->name('images.upload');
            Route::delete('image', 'ImageController@destroy')->name('images.destroy');
        });
    });
});

Auth::routes();
