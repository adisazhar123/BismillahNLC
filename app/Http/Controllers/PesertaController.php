<?php

namespace App\Http\Controllers;

use Session;
use App\Packet;
use App\Question;
use App\GeneratedPacket;
use App\TeamPacket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function showLogin(){
      return view('peserta.login');
    }

    public function showExam(){
      $team_ans="";
      $ans_stats='';
      $question_id="";
      $ans_label_index = ['A', 'B', 'C', 'D', 'E'];

      //Utk menyimpan id_packet ujian hari ini
      $packets_today_arr = array();
      //Set timezone
      $date_today = Carbon::now('Asia/Jakarta');
      //select id_packet yg aktif hari ini
      $packets_today = Packet::where('active_date', $date_today->toDateString())->where('active', 1)->select('id_packet')->get();

      if ($packets_today->isEmpty()) {
        //Gak ada ujian hari ini
        return "Tidak ada ujian hari ini! sessionId: ".  Session::getId();
      }

      //Ada ujian hari ini

      //id_packet disimpan di array
      foreach ($packets_today as $p) {
        $packets_today_arr[] = $p->id_packet;
      }

      //Utk mencari paket ujian yang udah diassign tapi belum diselesaikan oleh tim pada hari ini
      $team_packet = TeamPacket::whereIn('id_packet', $packets_today_arr)->where('id_team', Auth::user()->id)
                    ->where('has_finished', 0)->first();

      //Kalo ada yg belum selesai
      if($team_packet){
        $has_time = Packet::find($team_packet->id_packet);
        $time_now = $date_today->toTimeString();
        Session::put('team_packet_id', $team_packet->id);

        //Cek masih ada waktu gak
        if (strtotime($time_now) >= strtotime($has_time['start_time']) && strtotime($time_now) <= strtotime($has_time['end_time'])) {
          //Melanjutkan ujian
          echo "Kurang segini waktunya dalam detik: ";
          echo strtotime($has_time['end_time'])-strtotime($time_now);
          echo "<br>";
          echo "Time now ";
          return view('peserta.ujian')->with('answers', explode(",", $team_packet->team_ans))
          ->with('answers_stats', explode(",", $team_packet->ans_stats))->with('ans_index', $ans_label_index)
          ->with('id_team_packet', $team_packet->id)->with('packet', $team_packet->packet_file_directory)
          ->with('packet_info', $has_time)->with('time_now', $time_now);

          // return "Melanjutkan ujian (1)";
        }
        else if (strtotime($time_now) <= strtotime($has_time['start_time'])) {
          //Waktu belum mulai. sabar sek
          return "Mohon bersabar. Ujian akan mulai pukul... (1)";
        }else {
          //Waktu sudah habis
          //has_finished = 1
          return "Tidak ada ujian hari ini atau waktu anda sudah habis! (1)";
        }

      }else{ //Kalo belum dapat paket
        //Mendapatkan paket scr random utk diassign ke tim
        $packet = Packet::where('active_date', $date_today->toDateString())->where('active', 1)->inRandomOrder()->first();
        $assigned_packet = GeneratedPacket::where('id_packet', $packet['id_packet'])->inRandomOrder()->first();
        $team_packet = new TeamPacket;
        $team_packet->id_packet = $packet['id_packet'];
        $team_packet->id_generated_packet = $assigned_packet['id'];
        $team_packet->id_team = Auth::user()->id;
        $team_packet->packet_file_directory = $assigned_packet['packet_file_directory'];
        $team_packet->has_finished = 0;
        //$team_packet->has_started = 0;

        //init jawaban tim
        for ($i=1; $i <=90 ; $i++) {
          $team_ans.= '0,';
          $ans_stats.='0,';
        }
        $team_packet->team_ans = $team_ans;
        $team_packet->ans_stats = $ans_stats;

        $team_packet->save();

        Session::put('team_packet_id', $team_packet->id);
        $time_now = $date_today->toTimeString();

        //Cek kalo uda memenuhi start_time paket ujian
        if (strtotime($packet['start_time']) <= strtotime($time_now) && strtotime($time_now) <= strtotime($packet['end_time'])) {
          //Mulai ujian bro
          return "Memulai ujian (2)";
          //return view
        }else if (strtotime($time_now) <= strtotime($packet['start_time'])){
          //Tunggu sebentar ya bro. harap bersabar!
          return "Mohon bersabar. Ujian akan mulai pukul... (2)";
        }else {
          //Waktu sudah habis
          return "Tidak ada ujian hari ini atau waktu anda sudah habis! (2) ";
        }
      }
      return view('peserta.ujian');
    }

    public function showPetunjuk(){
      return view('peserta.petunjuk');
    }

    public function home(){
      return view('peserta.home');
    }

    public function showWelcome(){
      //Cek ada ujian gak hari ini
      //Utk menyimpan id_packet ujian hari ini
      $packets_today_arr = array();
      //Set timezone
      $date_today = Carbon::now('Asia/Jakarta');
      //select id_packet yg aktif hari ini
      $packets_today = Packet::where('active_date', $date_today->toDateString())->where('active', 1)->select('id_packet')->get();

      //variable utk nyimpen flag ada ujian gak. 0 = ga ada, 1 = ada, 2 = ada dan udah diassign (peserta pernah close browser atau logout)
      $exam=1;

      if ($packets_today->isEmpty()) {
        //Gak ada ujian hari ini
        $exam=0;
      }else {
        //Ada ujian hari ini

        //id_packet disimpan di array
        foreach ($packets_today as $p) {
          $packets_today_arr[] = $p->id_packet;
        }

        //Utk mencari paket ujian yang udah diassign tapi belum diselesaikan oleh tim pada hari ini
        $team_packet = TeamPacket::whereIn('id_packet', $packets_today_arr)->where('id_team', Auth::user()->id)
                      ->where('has_finished', 0)->first();
        if ($team_packet)
          $exam = 2;
      }
      return view('peserta.welcome-peserta')->with('exam', $exam);
    }

    //Untuk submit jawaban, dijadikan array terus convert ke string utk store di DB
    public function submitAns(Request $request){
      $team_packet = TeamPacket::find($request->id_team_packet);
      $ans = explode(',', $team_packet->team_ans);
      $stats = explode(',', $team_packet->ans_stats);

      $ans[$request->q_index-1] = $request->value;
      $stats[$request->q_index-1] = "green";

      $team_packet->team_ans = implode(',', $ans);
      $team_packet->ans_stats = implode(',', $stats);

      if ($team_packet->save()) {
        return response()->json(['message' => 'ok'], 201);
      }else {
        return response()->json(['message' => 'fail'], 500);
      }
    }

    //Untuk submit status jawaban e.g. "ragu", dijadikan array terus convert ke string utk store di DB
    public function submitAnsStat(Request $request){
      $team_packet = TeamPacket::find($request->id_team_packet);
      $stats = explode(',', $team_packet->ans_stats);
      $stats[$request->q_index-1] = "orange";
      $team_packet->ans_stats = implode(',', $stats);

      if ($team_packet->save()) {
        return response()->json(['message' => 'ok'], 201);
      }else {
        return response()->json(['message' => 'fail'], 500);
      }
    }

    //Untuk reset jawaban, dijadikan array terus convert ke string utk store di DB
    public function resetAns(Request $request){
      $team_packet = TeamPacket::find($request->id_team_packet);
      $stats = explode(',', $team_packet->ans_stats);
      $ans = explode(',', $team_packet->team_ans);

      $ans[$request->q_index-1] = '0';
      $stats[$request->q_index-1] = "0";

      $team_packet->team_ans = implode(',', $ans);
      $team_packet->ans_stats = implode(',', $stats);

      if ($team_packet->save()) {
        return response()->json(['message' => 'ok'], 201);
      }else {
        return response()->json(['message' => 'fail'], 500);
      }
    }

    public function getQuestions(){
      $questions = Question::all();
      return $questions;
    }

    //Untuk download packet PDF
    public function downloadPacket(Request $request){
      if (!Session::has('team_packet_id')) {
        return redirect()->route('peserta.home');
      }
      $packet_path = TeamPacket::find(Session::get('team_packet_id'))->packet_file_directory;
      return response()->file(storage_path()."/app/".$packet_path);
    }
}
