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
//Role: Peserta
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'PesertaController@showLogin')->name('login.home');
Route::get('/ujian', 'PesertaController@showExam')->name('team.exam');
Route::get('/petunjuk-ujian', 'PesertaController@showPetunjuk')->name('peserta.petunjuk');
Route::get('/peserta/home', 'PesertaController@home')->name('peserta.home');
Route::get('/peserta/welcome-screen', 'PesertaController@showWelcome')->name('peserta.welcome');
/*Will change to method PUT once connected to DB*/
Route::post('/peserta/submit-answer', 'PesertaController@submitAns')->name('peserta.submit.ans');
Route::post('/peserta/submit-answer-status', 'PesertaController@submitAnsStat')->name('peserta.submit.ans.stat');
Route::get('/peserta/get-questions', 'PesertaController@getQuestions')->name('peserta.get.questions');

//---------------------------------------------------------------------//

//Role: Admin
//Yang halaman ini belum diproteksi pakai Guard.
//Jadi tanpa login langsung akses ke /admin
Route::get('/admin', 'AdminController@index')->name('index.admin');
Route::get('/admin/get-teams', 'AdminController@getTeams')->name('get.teams.admin');
Route::get('/admin/packets', 'AdminController@packetPage')->name('packet.admin');
Route::get('/admin/get-packets', 'AdminController@getPackets')->name('get.packets.admin');
Route::post('/admin/new-packet', 'AdminController@newPacket')->name('new.packet.admin');
Route::delete('/admin/delete-packet', 'AdminController@deletePacket')->name('delete.packet.admin');
Route::get('/admin/get-packet-info', 'AdminController@getPacketInfo')->name('get.packet.info.admin');
Route::put('/admin/update-packet-answer', 'AdminController@updateAns')->name('update.packet.ans.admin');
