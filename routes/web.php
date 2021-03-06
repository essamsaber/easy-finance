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
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');
Route::resource('sources', 'IncomeSourcesController');
Route::resource('expense-items', 'ExpenseItemsController');
Route::resource('income', 'IncomeController');
Route::resource('payment', 'PaymentsController');
Route::get('profile', 'ProfileController@show');
Route::post('profile', 'ProfileController@update');
