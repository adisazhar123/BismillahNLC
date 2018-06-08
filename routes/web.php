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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'PesertaController@showLogin')->name('login.home');
Route::get('/ujian', 'PesertaController@showExam')->name('team.exam');
Route::get('/petunjuk-ujian', 'PesertaController@showPetunjuk')->name('peserta.petunjuk');
Route::get('/peserta/home', 'PesertaController@home')->name('peserta.home');
Route::get('/peserta/welcome-screen', 'PesertaController@showWelcome')->name('peserta.welcome');

/*Will change to method PUT once connected to DB*/
Route::post('/peserta/submit-answer', 'PesertaController@submitAns')->name('peserta.submit.ans');
Route::post('/peserta/submit-answer-status', 'PesertaController@submitAnsStat')->name('peserta.submit.ans.stat');
