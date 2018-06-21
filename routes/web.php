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
Auth::routes();

//Yang halaman ini belum diproteksi pakai Guard.
//Jadi tanpa login langsung akses ke /admin
Route::get('/admin', 'AdminController@index')->name('index.admin');
