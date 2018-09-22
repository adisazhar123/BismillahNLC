<?php

namespace App\Http\Controllers;

use Session;
use View;
use App\User;
use App\Announcement;
use App\Packet;
use App\Question;
use App\GeneratedPacket;
use App\TeamPacket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PesertaController extends Controller
{
    protected $server_time;

    public function __construct(){
      $this->server_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
      View::share('server_time', $this->server_time);
    }

    public function getServerTime(){
      return Carbon::now('Asia/Jakarta')->toDateTimeString();
    }

    public function showLogin(){
      return view('peserta.login');
    }

    public function changePsw(){
      return view('peserta.change-password');
    }

    public function announcementPage(){
      $packets = Packet::whereHas('generatedPackets')->where('type', 'warmup')->where('open', 1)
                  ->get();

      $pkts = Packet::where('type', 'warmup')->get();

      $pkt_arr = array();

      foreach ($pkts as $p) {
        $pkt_arr[] = $p->id_packet;
      }

      $announcements = Announcement::orderBy('id', 'DESC')->get();

      //menampilkan pilihan kloter yang telah dipilih
      $pilihan_kloter = TeamPacket::where('id_team', Auth::user()->role_id)->where('status', 1)->whereIn('id_packet', $pkt_arr)->select('id_packet')->first();

      return view('peserta.pengumuman')->with('packets', $packets)->with('pilihan_kloter', $pilihan_kloter)->with('announcements', $announcements);
    }

    public function updatePassword(Request $request){
      $user = User::find($request->user_id);
      if ($request->new_password===$request->new_password_retype) {
        $user->password = bcrypt($request->new_password);
          if ($user->save()) {
            return redirect()->back()->with('message', 'Password berhasil diperbaharui');
          }
      }
      return redirect()->back()->with('error', 'Password tidak cocok');
    }

    public function pilihKloter(Request $request){
      $team_ans='';
      $ans_stats='';
      $data = TeamPacket::firstOrNew(array('id_team' => Auth::user()->role_id, 'id_packet' => (int)$request->kloter));

      $id_generated = GeneratedPacket::where('id_packet', $request->kloter)->inRandomOrder()->first();

      $data->id_packet            = (int)$request->kloter;
      $data->id_generated_packet  = $id_generated['id'];
      $data->id_team              = Auth::user()->role_id;
      $data->status               = 1;
      $data->has_finished         = 0;

      $packet = Packet::find($request->kloter);
      $packet->current_capacity = (int)$packet->current_capacity + 1;

      $number_of_questions = count($packet->questions);

      for ($i=1; $i <=$number_of_questions ; $i++) {
        $team_ans.= '0,';
        $ans_stats.='0,';
      }

      $data->team_ans = $team_ans;
      $data->ans_stats = $ans_stats;
      $data->packet_file_directory = $id_generated->packet_file_directory;


      $data->save();
      $packet->save();

      //save in redis cache
      //format: id-packet_id-team_packet_id-type

      Redis::set('id-'.$data->id_packet.'-'.$data->id.'-ans', $data->team_ans);
      Redis::set('id-'.$data->id_packet.'-'.$data->id.'-stat', $data->ans_stats);


      return redirect()->back()->with('message', 'Kloter telah dipilih');
    }

    public function showExam(){
      // NOTE: untuk sementara halama ujian warmup dan penyisihan beda, karena warmup = 50 soal, penyisihan 90 soal...
      //untuk kedepannya di-dinamiskan, sekarang di hardcode
      $team_ans="";
      $ans_stats='';
      $question_id="";
      $ans_label_index = ['A', 'B', 'C', 'D', 'E'];

      //Utk menyimpan id_packet ujian hari ini
      $packets_today_arr = array();
      $packets_today_type = array();

      //Set timezone
      $date_today = Carbon::now('Asia/Jakarta');
      //select id_packet yg aktif hari ini
      $packets_today = Packet::where('active_date', $date_today->toDateString())->where('active', 1)->select('id_packet', 'type')->get();


      //Ada ujian hari ini

      //id_packet disimpan di array
      foreach ($packets_today as $p) {
        $packets_today_arr[] = $p->id_packet;
        $packets_today_type[] = $p->type;
      }

      //Utk mencari paket ujian yang udah diassign tapi belum diselesaikan oleh tim pada hari ini
      $team_packet = TeamPacket::whereIn('id_packet', $packets_today_arr)->where('id_team', Auth::user()->role_id)
                    ->where('has_finished', 0)->where('status', 1)->first();

      //Kalo ada yg belum selesai
      if($team_packet){
        $has_time = Packet::find($team_packet->id_packet);
        $time_now = $date_today->toTimeString();
        Session::put('team_packet_id', $team_packet->id);

        $warm_up = 0;

        if ($team_packet->packets->type == "warmup") {
          $warm_up = 1;
        }

        //Cek masih ada waktu gak
        if (strtotime($time_now) >= strtotime($has_time['start_time']) && strtotime($time_now) <= strtotime($has_time['end_time'])) {
          //Melanjutkan ujian
          // echo "Kurang segini waktunya dalam detik: ";
          // echo strtotime($has_time['end_time'])-strtotime($time_now);
          // echo "<br>";
          // echo "Time now ";

          if ($warm_up) {
            return view('peserta.ujian-warmup')->with('answers', explode(",", Redis::get('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans')))
            ->with('answers_stats', explode(",", Redis::get('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat')))->with('ans_index', $ans_label_index)
            ->with('id_team_packet', $team_packet->id)
            ->with('packet_info', $has_time)->with('time_now', $time_now);
          }

          return view('peserta.ujian')->with('answers', explode(",", Redis::get('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans')))
          ->with('answers_stats', explode(",", Redis::get('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat')))->with('ans_index', $ans_label_index)
          ->with('id_team_packet', $team_packet->id)
          ->with('packet_info', $has_time)->with('time_now', $time_now);

          // return "Melanjutkan ujian (1)";
        }
        else if (strtotime($time_now) <= strtotime($has_time['start_time'])) {
          //Waktu belum mulai. sabar sek
          //return "Mohon bersabar. Ujian akan mulai pukul". $has_time['start_time'];
          if ($warm_up) {
            return view('peserta.ujian-warmup')->with('start_time', $has_time['start_time']);

          }
          return view('peserta.ujian')->with('start_time', $has_time['start_time']);
        }else {
          //Waktu sudah habis
          //has_finished = 1
          //return "Tidak ada ujian hari ini atau waktu anda sudah habis! (1)";
          if ($warm_up) {
            return view('peserta.ujian-warmup')->with('finished', 1)->with('id_team_packet', $team_packet->id)
              ->with('packet_info', $has_time)->with('time_now', $time_now);
          }
          return view('peserta.ujian')->with('finished', 1)->with('id_team_packet', $team_packet->id)
            ->with('packet_info', $has_time)->with('time_now', $time_now);

        }

      }

      // NOTE: Uncomment here if you want to use assign-randomly

      /*else{ //Kalo belum dapat paket
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
          $has_time = Packet::find($team_packet->id_packet);
          return view('peserta.ujian')->with('id_team_packet', $team_packet->id)
          ->with('packet_info', $has_time)->with('time_now', $time_now)->with('ans_index', $ans_label_index);

        }else if (strtotime($time_now) <= strtotime($packet['start_time'])){
          //Tunggu sebentar ya bro. harap bersabar!
          return "Mohon bersabar. Ujian akan mulai pukul... (2)";
        }else {
          //Waktu sudah habis
          return "Tidak ada ujian hari ini atau waktu anda sudah habis! (2) ";
        }
      }
      return view('peserta.ujian');*/
    }

    public function showPetunjuk(){
      return view('peserta.petunjuk');
    }

    public function home(){
      return view('peserta.home');

    }

    public function showWelcome(){
      View::share('team_name', Auth::user()->name);

      //Cek ada ujian gak hari ini
      //Utk menyimpan id_packet ujian hari ini
      $packets_today_arr = array();
      $packets_today_type = array();
      //Set timezone
      $date_today = Carbon::now('Asia/Jakarta');
      //select id_packet yg aktif hari ini
      $packets_today = Packet::where('active_date', $date_today->toDateString())->where('active', 1)->select('id_packet', 'type')->get();



      //variable utk nyimpen flag ada ujian gak. 0 = ga ada, 1 = ada tapi belum diassign, 2 = ada dan udah diassign (peserta pernah close browser atau logout)
      //3 = udah diassign tapi start_time belum mulai

      $exam=1;


      if ($packets_today->isEmpty()) {
        //Gak ada ujian hari ini
        $exam=0;
        return view('peserta.welcome-peserta')->with('exam', $exam);
      }else {
        //Ada ujian hari ini
        //id_packet disimpan di array
        foreach ($packets_today as $p) {
          $packets_today_arr[] = $p->id_packet;
          $packets_today_type[] = $p->type;
        }

        //Utk mencari paket ujian yang udah diassign tapi belum diselesaikan oleh tim pada hari ini
        $team_packet = TeamPacket::whereIn('id_packet', $packets_today_arr)->where('id_team', Auth::user()->role_id)
                      ->where('has_finished', 0)->where('status', 1)->first();

        // NOTE: uncomment utk assign randomly
        //belum dpt assign packet
        // if (!$team_packet) {
        //   return view('peserta.welcome-peserta')->with('exam', $exam);
        //
        // }

        if (!$team_packet) {
          return view('peserta.welcome-peserta')->with('exam', $exam);
        }

        $assigned_packet = Packet::find($team_packet->id_packet);

        if ($team_packet && strtotime($assigned_packet->start_time) < strtotime($date_today->toTimeString()))
          $exam = 2;
        else if ($team_packet && strtotime($assigned_packet->start_time) > strtotime($date_today->toTimeString()))
          $exam = 3;
      }
      return view('peserta.welcome-peserta')->with('exam', $exam)->with('start_time', $assigned_packet->start_time)
      ->with('packet_info', $assigned_packet);
    }

    //Untuk submit jawaban, dijadikan array terus convert ke string utk store di DB
    public function submitAns(Request $request){
      // NOTE: Pake redis cache

      $ans = Redis::get('id-'.$request->id_packet.'-'.$request->id_team_packet.'-ans');

      $ans = explode(',', $ans);

      $stat = Redis::get('id-'.$request->id_packet.'-'.$request->id_team_packet.'-stat');
      $stat = explode(',', $stat);

      $ans[$request->q_index-1] = $request->value;
      $stat[$request->q_index-1] = "green";

      $ans = implode(',', $ans);
      $stat = implode(',', $stat);

      Redis::set('id-'.$request->id_packet.'-'.$request->id_team_packet.'-ans', $ans);
      Redis::set('id-'.$request->id_packet.'-'.$request->id_team_packet.'-stat', $stat);

      return response()->json(['message' => 'ok'], 200);

      // NOTE: Uncomment bawah kalo mau insert lgsg ke DB
      // $team_packet = TeamPacket::find($request->id_team_packet);
      // $ans = explode(',', $team_packet->team_ans);
      // $stats = explode(',', $team_packet->ans_stats);
      //
      // $ans[$request->q_index-1] = $request->value;
      // $stats[$request->q_index-1] = "green";
      //
      // $team_packet->team_ans = implode(',', $ans);
      // $team_packet->ans_stats = implode(',', $stats);
      //
      // if ($team_packet->save()) {
      //   return response()->json(['message' => 'ok'], 201);
      // }else {
      //   return response()->json(['message' => 'fail'], 500);
      // }
    }

    //Untuk submit status jawaban e.g. "ragu", dijadikan array terus convert ke string utk store di DB
    public function submitAnsStat(Request $request){
      $stat = Redis::get('id-'.$request->id_packet.'-'.$request->id_team_packet.'-stat');
      $stat = explode(',', $stat);
      $stat[$request->q_index-1] = "orange";
      $stat = implode(',', $stat);
      Redis::set('id-'.$request->id_packet.'-'.$request->id_team_packet.'-stat', $stat);

      return response()->json(['message' => 'ok'], 200);

      // $team_packet = TeamPacket::find($request->id_team_packet);
      // $stats = explode(',', $team_packet->ans_stats);
      // $stats[$request->q_index-1] = "orange";
      // $team_packet->ans_stats = implode(',', $stats);
      //
      // if ($team_packet->save()) {
      //   return response()->json(['message' => 'ok'], 201);
      // }else {
      //   return response()->json(['message' => 'fail'], 500);
      // }
    }

    //Untuk reset jawaban, dijadikan array terus convert ke string utk store di DB
    public function resetAns(Request $request){
      $ans = Redis::get('id-'.$request->id_packet.'-'.$request->id_team_packet.'-ans');

      $ans = explode(',', $ans);

      $stat = Redis::get('id-'.$request->id_packet.'-'.$request->id_team_packet.'-stat');
      $stat = explode(',', $stat);

      $ans[$request->q_index-1] = "0";
      $stat[$request->q_index-1] = "0";

      $ans = implode(',', $ans);
      $stat = implode(',', $stat);

      Redis::set('id-'.$request->id_packet.'-'.$request->id_team_packet.'-ans', $ans);
      Redis::set('id-'.$request->id_packet.'-'.$request->id_team_packet.'-stat', $stat);

      return response()->json(['message' => 'ok'], 200);

      // $team_packet = TeamPacket::find($request->id_team_packet);
      // $stats = explode(',', $team_packet->ans_stats);
      // $ans = explode(',', $team_packet->team_ans);
      //
      // $ans[$request->q_index-1] = '0';
      // $stats[$request->q_index-1] = "0";
      //
      // $team_packet->team_ans = implode(',', $ans);
      // $team_packet->ans_stats = implode(',', $stats);
      //
      // if ($team_packet->save()) {
      //   return response()->json(['message' => 'ok'], 201);
      // }else {
      //   return response()->json(['message' => 'fail'], 500);
      // }
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

    public function submitExam(Request $request){
      $ans = Redis::get('id-'.$request->id_packet.'-'.$request->id_team_packet.'-ans');
      $stat = Redis::get('id-'.$request->id_packet.'-'.$request->id_team_packet.'-stat');

      $team_packet = TeamPacket::find($request->id_team_packet);
      $team_packet->has_finished = 1;
      $team_packet->status = 0;
      $team_packet->team_ans = $ans;
      $team_packet->ans_stats = $stat;
      $team_packet->final_score = null;

      if ($team_packet->save()) {
        return "ok";
      }
      return "fail";
    }

    public function getMyScores(){
      $warm_up_ids = Packet::where('type', 'warmup')->get();
      $wu_ids = array();

      foreach ($warm_up_ids as $wu) {
        $wu_ids [] = $wu->id_packet;
      }
      //cari ujian warmup yang udah dinilai
      $team_packets = TeamPacket::with('packets')->where('id_team', Auth::user()->role_id)->whereIn('id_packet', $wu_ids)
                      ->where('has_finished', 1)->where('final_score', '!=', null)->get();

      return view('peserta.hasil-ujian', ['team_packets' => $team_packets]);
    }

    public function viewTutorialWarmUp(){
      return response()->file(storage_path()."/app/public/tutorial/tutorial_warmup.pdf");
    }

}
