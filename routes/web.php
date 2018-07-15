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
Route::get('/', 'PagesController@index')->name('index');


//Role: Peserta
Route::middleware(['single_session', 'participant_only'])->group(function(){
  Route::get('/ujian', 'PesertaController@showExam')->name('team.exam');
  Route::get('/petunjuk-ujian', 'PesertaController@showPetunjuk')->name('peserta.petunjuk');
  Route::get('/peserta/home', 'PesertaController@home')->name('peserta.home');
  Route::get('/peserta/welcome-screen', 'PesertaController@showWelcome')->name('peserta.welcome');
  Route::put('/peserta/submit-answer', 'PesertaController@submitAns')->name('peserta.submit.ans');
  Route::put('/peserta/submit-answer-status', 'PesertaController@submitAnsStat')->name('peserta.submit.ans.stat');
  Route::get('/peserta/get-questions', 'PesertaController@getQuestions')->name('peserta.get.questions');
  Route::put('/peserta/reset-answer', 'PesertaController@resetAns')->name('peserta.reset.ans');
  Route::get('/peserta/download-packet', 'PesertaController@downloadPacket')->name('peserta.download.packet');
  Route::put('/peserta/finish-exam', 'PesertaController@submitExam')->name('peserta.submit.exam');
});


//Role: Admin
Route::middleware(['admin_only'])->group(function(){
  Route::get('/admin', 'AdminController@index')->name('index.admin');
  Route::get('/admin/get-teams', 'AdminController@getTeams')->name('get.teams.admin');
  Route::get('/admin/packets', 'AdminController@packetPage')->name('packet.admin');
  Route::get('/admin/get-packets', 'AdminController@getPackets')->name('get.packets.admin');
  Route::post('/admin/new-packet', 'AdminController@newPacket')->name('new.packet.admin');
  Route::delete('/admin/delete-packet', 'AdminController@deletePacket')->name('delete.packet.admin');
  Route::get('/admin/get-packet-info', 'AdminController@getPacketInfo')->name('get.packet.info.admin');
  Route::put('/admin/update-packet-answer', 'AdminController@updateAns')->name('update.packet.ans.admin');
  Route::put('/admin/toggle-packet', 'AdminController@changePacketStatus')->name('toggle.packet.admin');
  Route::get('/admin/get-packet-details', 'AdminController@getPacketDetails')->name('get.packet.details.admin');
  Route::post('/admin/update-packet', 'AdminController@updatePacket')->name('update.packet.admin');
  Route::get('/admin/statistics', 'AdminController@statisticsPage')->name('statistics.page.admin');
  Route::get('/admin/get-questions/{id_packet}', 'AdminController@getPacketQuestions')->name('get.questions.admin');
  Route::get('/admin/list-questions/{id}', 'AdminController@listSoal')->name('list.soal.page.admin');
  Route::get('/admin/get-question-details', 'AdminController@getQuestionDetails')->name('get.question.details.admin');
  Route::post('/admin/add-new-question', 'AdminController@addNewQuestion')->name('add.new.question.admin');
  Route::put('/admin/update-question', 'AdminController@updateQuestion')->name('update.question.admin');
  Route::delete('/admin/delete-question', 'AdminController@deleteQuestion')->name('delete.question.admin');
  Route::post('/admin/new-team', 'AdminController@newTeam')->name('new.team.admin');
  Route::get('/admin/get-team', 'AdminController@getTeamtoUpdate')->name('get.team.to.update');
  Route::put('/admin/update-team', 'AdminController@updateTeam')->name('update.team.admin');
  Route::get('/admin/generate-pdf', 'AdminController@listPdfPage')->name('list.pdf.page.admin');
  Route::get('/admin/get-packets-for-pdf', 'AdminController@getPacketsforPdf')->name('get.packets.for.pdf.admin');
  Route::get('/pdf', 'PDFController@index');
  Route::post('/admin/generate-packets', 'PDFController@generatePDF')->name('generate.packets.admin');
  Route::get('/admin/scoreboard', 'AdminController@scoreBoardPage')->name('scoreboard.page.admin');
  Route::get('/admin/list-pdf/{id}', 'AdminController@listPdf')->name('list.pdf.admin');
  Route::delete('/admin/delete-pdf', 'AdminController@deletePdf')->name('delete.pdf.admin');
  Route::get('/admin/view-pdf/{id}', 'AdminController@viewPdf')->name('view.pdf.admin');
});
// TODO:
Route::put('/admin/generate-score', 'AdminController@generateScore')->name('generate.score.admin');
Route::get('/admin/get-team-scores', 'AdminController@getTeamScores')->name('get.team.scores.admin');
Route::get('/admin/generate-score-page', 'AdminController@generateScorePage')->name('generate.score.page.admin');
Route::get('/admin/get-packets-to-score', 'AdminController@getPacketstoScore')->name('get.packets.to.score.admin');


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    '\UniSharp\LaravelFilemanager\Lfm::routes()';
});
