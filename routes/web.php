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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('customer/{any}', 'CustomerController@index')->where('any', '.*');

Route::prefix('waiter')->group(function () {
    Route::prefix('tables')->group(function () {
        Route::get('/', 'TableController@index');
        Route::post('load_data', 'TableController@loadData');
        Route::post('insert', 'TableController@insert');
        Route::post('update/{id}', 'TableController@update');
    });
});