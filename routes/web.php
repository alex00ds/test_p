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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/balance', 'WalletController@index')->name('balance');
Route::post('/balance', 'WalletController@addBalance');

Route::get('/deposit', 'DepositController@index')->name('deposit');
Route::post('/deposit', 'DepositController@addDeposit');

Route::get('/deposits', 'DepositController@table')->name('deposits');

Route::get('/transactions', 'TransactionController@table')->name('transactions');
