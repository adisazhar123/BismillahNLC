<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use App\Team;
use App\TeamPacket;
use App\UserListing;
use App\Packet;
use App\Question;
use Carbon\Carbon;
use App\User;
use App\GeneratedPacket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Announcement;
use Auth;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    protected $server_time;

    public function __construct(){
      $this->server_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
      View::share('server_time', $this->server_time);
    }

    public function getServerTime(){
      return Carbon::now('Asia/Jakarta')->toDateTimeString();
    }

    //halaman index
    public function index(){
      return view('admin.daftar-teams');
    }

    //halaman index
    public function listUserAdmin(){
      return view('admin.daftar-user');
    }

    //fungsi utk GET teams (ngisi datatable)
    public function getUser(){
      $teams = UserListing::all(['id','name','email']);
      return response()->json(['data'=> $teams]);
    }

    //fungsi utk GET teams (ngisi datatable)
    public function getTeams(){
      $teams = Team::all();
      return response()->json(['data'=> $teams]);
    }

    //halaman paket
    public function packetPage(){
      return view('admin.daftar-packets');
    }

    //fungsi utk GET paket (ngisi datatable)
    public function getPackets(){
      $packets = Packet::select('id_packet','name','active_date','active')->get();
      return response()->json(['data'=>$packets]);
    }

    public function newPacket(Request $request){
       $packet = new Packet;
       $packet->name = $request->packet_name;
       $packet->active_date = $request->active_date;
       $packet->start_time = $request->start_time;
       $packet->end_time = $request->end_time;
       $packet->duration = $request->duration;
       $packet->active = 0;
       $packet->type = $request->type;
       if ($packet->type =='warmup' ) {
         $packet->open = (int)$request->status;
         $packet->capacity = $request->capacity;
       }else {
         $packet->open = 1;
       }

       if ($packet->save())
        return "ok";

    }

    public function getPacketInfo(Request $request){
      $questions = Question::where('id_packet', $request->id_packet)->get();
      return response()->json($questions);
    }

    public function deletePacket(Request $request){
      $packet = Packet::find($request->id_packet);
      if ($packet->delete()) {
        return "ok";
      }
    }

    public function updateAns(Request $request){
      $question = Question::where('id_packet', $request->id_packet)
                  ->where('question_no', $request->question_no)
                  ->first();
      $question->right_ans = $request->right_ans;
      if ($question->save()) return "ok";
      return "fail";
    }

    public function changePacketStatus(Request $request){
      $packet = Packet::find($request->id_packet);
      if ($packet->active == 1)
        $packet->active = 0;
      else
        $packet->active = 1;

      if ($packet->save())
        return "ok".$packet->active;
      return "fail";
    }

    public function getPacketDetails(Request $request){
      $packet = Packet::select('id_packet','name','active_date', 'start_time', 'end_time', 'duration', 'type', 'open', 'capacity')->find($request->id_packet);
      return response()->json($packet);
    }

    public function updatePacket(Request $request){
      $packet = Packet::find($request->id_packet);
      $packet->name = $request->packet_name;
      $packet->active_date = $request->active_date;
      $packet->start_time = $request->start_time;
      $packet->end_time = $request->end_time;
      $packet->duration = $request->duration;
      $packet->type = $request->type;
      if ($packet->type =='warmup' ) {
        $packet->open = (int)$request->status;
        $packet->capacity = $request->capacity;
      }else {
        $packet->open = 1;
      }

       if ($packet->save()){
         return "ok";
       }
       return "fail";
    }


    public function statisticsPage(){
      return view('admin.statistics');
    }

    //for datatable
    public function getPacketQuestions($id_packet){
      $questions = Question::where('id_packet', $id_packet)->get()->toArray();

      $data = array();
      $question;
      $ans;

      for ($x=0; $x<count($questions); $x++) {
        $description='';
        if (isset ($questions[$x]['description']) && !empty($questions[$x]['description']))
          $description = $questions[$x]['description'];
        $question = $description.$questions[$x]['question'];
        $id_question = $questions[$x]['id_question'];
        //$question .= "<ol type='A'>";

        $ans = "<ol type='A'>";
        $ans = str_replace('</p>', '', str_replace('<p>', '', $ans));
        $question .= $ans;

          for ($i=1; $i <=5 ; $i++) {
            if ($i == $questions[$x]['right_ans']) {
              $ans = "<strong><li>".$questions[$x]['option_'.$i]."</li></strong>";
              $ans = str_replace('</p>', '', str_replace('<p>', '', $ans));
              $question .= $ans;
            }else{
              $ans = "<li>".$questions[$x]['option_'.$i]."</li>";
              $ans = str_replace('</p>', '', str_replace('<p>', '', $ans));
              $question .= $ans;
            }
          }

        "</ol>";
        $row = array();
        $button = "<button class='btn btn-info' id=edit question-id='$id_question'><i class='fa fa-pencil-square' aria-hidden=true></i></button><button class='btn btn-danger' id=delete question-id='$id_question'><i class='fa fa-trash' aria-hidden=true></i></button>";
        $row[]= $questions[$x]['id_question'];
        $row[] = $question;
        $row[] = $button;
        $data[] = $row;
      }

      return response()->json(["data"=>$data]);
    }

    public function listSoal($id){
      $packet_name = Packet::find($id)->name;
      return view('admin.list-soal')->with('id_packet', $id)->with('packet_name', $packet_name);
    }

    public function getQuestionDetails(Request $request){
      $question = Question::find($request->question_id);
      return response()->json($question);
    }

    public function addNewQuestion(Request $request){
      // TODO: Kalo udah deploy di server harus diganti pathnya lol :')

      // dilakukan str_replace karena Unisharp Laravelfilemanager menyimpan sourcenya menggunakan URL relative, sedangkan
      // DOMPDF gabisa membacanya jadi tak replace dengan asset()

      //Ini utk ngereplace path math formula Wiris karena DOMPDF gabisa mbaca

      if (empty($request->description))
        $request->description = '';

      $data_question = array();
      $data_option1 = array();
      $data_option2 = array();
      $data_option3 = array();
      $data_option4 = array();
      $data_option5 = array();
      $data_description = array();
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->question, $data_question);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_1, $data_option1);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_2, $data_option2);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_3, $data_option3);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_4, $data_option4);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_5, $data_option5);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->description, $data_description);

      $question = $request->question;
      $option1 = $request->option_1;
      $option2 = $request->option_2;
      $option3 = $request->option_3;
      $option4 = $request->option_4;
      $option5 = $request->option_5;
      $description = $request->description;

      //Filter Math formulas
      if (isset($data_question[0]) && !empty($data_question[0])){
        $keep_question = array();

        for ($i=0; $i < count($data_question[0]); $i++) {
          $keep_question[$i] = substr_replace($data_question[0][$i], '/', 2, 0);
          $keep_question[$i] = substr_replace($keep_question[$i], '/', 5, 0);

        }

          for ($i=0; $i <count($data_question[0]) ; $i++) {
            $question = str_replace(url('/').'/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_question[0][$i], asset('storage/cache/'.$keep_question[$i].'.png'), $question);
          }
      }
      if (isset($data_option1[0]) && !empty($data_option1[0])){
        $keep_option1 = array ();

        for ($i=0; $i < count($data_option1[0]); $i++) {
          $keep_option1[$i] =  substr_replace($data_option1[0][$i], '/', 2, 0);
          $keep_option1[$i] = substr_replace($keep_option1[$i], '/', 5, 0);
        }
        for ($i=0; $i <count($data_option1[0]) ; $i++) {
          $option1 = str_replace(url('/').'/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option1[0][$i], asset('storage/cache/'.$keep_option1[$i].'.png'), $option1);
        }
      }

      if (isset($data_option2[0]) && !empty($data_option2[0])){
        $keep_option2 = array();

        for ($i=0; $i < count($data_option2[0]); $i++) {
          $keep_option2[$i] =  substr_replace($data_option2[0][$i], '/', 2, 0);
          $keep_option2[$i] = substr_replace($keep_option2[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option2[0]); $i++) {
          $option2 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option2[0][$i]."/", asset('storage/cache/'.$keep_option2[$i].'.png'), $option2);
        }
      }
      if (isset($data_option3[0]) && !empty($data_option3[0])){
        $keep_option3 = array();

        for ($i=0; $i < count($data_option3[0]); $i++) {
          $keep_option3[$i] =  substr_replace($data_option3[0][$i], '/', 2, 0);
          $keep_option3[$i] = substr_replace($keep_option3[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option3[0]); $i++) {
          $option3 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option3[0][$i]."/", asset('storage/cache/'.$keep_option3[$i].'.png'), $option3);
        }
      }
      if (isset($data_option4[0]) && !empty($data_option4[0])) {
        $keep_option4 = array();

        for ($i=0; $i < count($data_option4[0]); $i++) {
          $keep_option4[$i] =  substr_replace($data_option4[0][$i], '/', 2, 0);
          $keep_option4[$i] = substr_replace($keep_option4[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option4[0]); $i++) {
          $option4 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option4[0][$i]."/", asset('storage/cache/'.$keep_option4[$i].'.png'), $option4);
        }
      }
      if (isset($data_option5[0]) && !empty($data_option5[0])){
        $keep_option5 = array();

        for ($i=0; $i < count($data_option5[0]); $i++) {
          $keep_option5[$i] =  substr_replace($data_option5[0][$i], '/', 2, 0);
          $keep_option5[$i] = substr_replace($keep_option5[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option5[0]); $i++) {
          $option5 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option5[0][$i]."/", asset('storage/cache/'.$keep_option5[$i].'.png'), $option5);
        }
      }
      if (isset($data_description[0]) && !empty($data_description[0])){

        $keep_description = array();

        for ($i=0; $i < count($data_description[0]); $i++) {
          $keep_description[$i] =  substr_replace($data_description[0][$i], '/', 2, 0);
          $keep_description[$i] = substr_replace($keep_description[$i], '/', 5, 0);
        }

        for ($i=0; $i < count($data_description[0]); $i++) {
          $description = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_description[0][$i]."/", asset('storage/cache/'.$keep_description[$i].'.png'), $description);
        }

      }

      $question = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $question);
      $option1 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option1);
      $option2 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option2);
      $option3 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option3);
      $option4 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option4);
      $option5 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option5);
      $description = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $description);

      $question = Question::create([
        'id_packet' => $request->id_packet,
        'option_1' => $option1,
        'option_2' => $option2,
        'option_3' => $option3,
        'option_4' => $option4,
        'option_5' => $option5,
        'question' => $question,
        'right_ans' => $request->right_ans,
        'related' => $request->related,
        'description' =>$description
      ]);
      return "ok";
    }

    public function updateQuestion(Request $request){
      $new_question = Question::find($request->id_question);

      if (empty($request->description))
        $request->description = '';

      // dilakukan str_replace karena Unisharp Laravelfilemanager menyimpan sourcenya menggunakan URL relative, sedangkan
      // DOMPDF gabisa membacanya jadi tak replace dengan asset()

      //Ini utk ngereplace path math formula Wiris karena DOMPDF gabisa mbaca
      $data_question = array();
      $data_option1 = array();
      $data_option2 = array();
      $data_option3 = array();
      $data_option4 = array();
      $data_option5 = array();
      $data_description = array();

      // TODO: Fix this urgent bug
      // BUG: ga ke replace kalo > 1 image wiris
      // NOTE: Remember buat adis ini ada bug!!! jadi kalo wiris image ada lebih > 1 dia ga keganti
      //solusinya untuk preg_match_all biar dapet semua formula_id nya, taru dalem array, terus di loop
      //sebanyak array lengthnya agar bisa direplace . cek bawah!

      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->question, $data_question);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_1, $data_option1);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_2, $data_option2);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_3, $data_option3);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_4, $data_option4);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_5, $data_option5);
      preg_match_all("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->description, $data_description);

      $question = $request->question;
      $option1 = $request->option_1;
      $option2 = $request->option_2;
      $option3 = $request->option_3;
      $option4 = $request->option_4;
      $option5 = $request->option_5;
      $description = $request->description;

      if (isset($data_question[0]) && !empty($data_question[0])){
        $keep_question = array();


        for ($i=0; $i < count($data_question[0]); $i++) {
          $keep_question[$i] = substr_replace($data_question[0][$i], '/', 2, 0);
          $keep_question[$i] = substr_replace($keep_question[$i], '/', 5, 0);

        }

          for ($i=0; $i <count($data_question[0]) ; $i++) {
            $question = str_replace(url('/').'/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_question[0][$i], asset('storage/cache/'.$keep_question[$i].'.png'), $question);
          }
      }
      if (isset($data_option1[0]) && !empty($data_option1[0])){
        $keep_option1 = array ();

        for ($i=0; $i < count($data_option1[0]); $i++) {
          $keep_option1[$i] =  substr_replace($data_option1[0][$i], '/', 2, 0);
          $keep_option1[$i] = substr_replace($keep_option1[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option1[0]); $i++) {
          $option1 = str_replace(url('/').'/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option1[0][$i], asset('storage/cache/'.$keep_option1[$i].'.png'), $option1);
        }
      }

      if (isset($data_option2[0]) && !empty($data_option2[0])){
        $keep_option2 = array();

        for ($i=0; $i < count($data_option2[0]); $i++) {
          $keep_option2[$i] =  substr_replace($data_option2[0][$i], '/', 2, 0);
          $keep_option2[$i] = substr_replace($keep_option2[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option2[0]); $i++) {
          $option2 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option2[0][$i]."/", asset('storage/cache/'.$keep_option2[$i].'.png'), $option2);
        }
      }
      if (isset($data_option3[0]) && !empty($data_option3[0])){
        $keep_option3 = array();

        for ($i=0; $i < count($data_option3[0]); $i++) {
          $keep_option3[$i] =  substr_replace($data_option3[0][$i], '/', 2, 0);
          $keep_option3[$i] = substr_replace($keep_option3[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option3[0]); $i++) {
          $option3 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option3[0][$i]."/", asset('storage/cache/'.$keep_option3[$i].'.png'), $option3);
        }
      }
      if (isset($data_option4[0]) && !empty($data_option4[0])) {
        $keep_option4 = array();

        for ($i=0; $i < count($data_option4[0]); $i++) {
          $keep_option4[$i] =  substr_replace($data_option4[0][$i], '/', 2, 0);
          $keep_option4[$i] = substr_replace($keep_option4[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option4[0]); $i++) {
          $option4 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option4[0][$i]."/", asset('storage/cache/'.$keep_option4[$i].'.png'), $option4);
        }
      }
      if (isset($data_option5[0]) && !empty($data_option5[0])){
        $keep_option5 = array();

        for ($i=0; $i < count($data_option5[0]); $i++) {
          $keep_option5[$i] =  substr_replace($data_option5[0][$i], '/', 2, 0);
          $keep_option5[$i] = substr_replace($keep_option5[$i], '/', 5, 0);
        }
        for ($i=0; $i < count($data_option5[0]); $i++) {
          $option5 = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_option5[0][$i]."/", asset('storage/cache/'.$keep_option5[$i].'.png'), $option5);
        }
      }
      if (isset($data_description[0]) && !empty($data_description[0])){

        $keep_description = array();

        for ($i=0; $i < count($data_description[0]); $i++) {
          $keep_description[$i] =  substr_replace($data_description[0][$i], '/', 2, 0);
          $keep_description[$i] = substr_replace($keep_description[$i], '/', 5, 0);
        }

        for ($i=0; $i < count($data_description[0]); $i++) {
          $description = preg_replace("/^".'\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php?formula='.$data_description[0][$i]."/", asset('storage/cache/'.$keep_description[$i].'.png'), $description);
        }

      }

      $question = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $question);
      $option1 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option1);
      $option2 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option2);
      $option3 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option3);
      $option4 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option4);
      $option5 = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $option5);
      $description = str_replace(url('/').'/nlc-filemanager/app/public', asset('storage'), $description);

      $new_question->description = $description;
      $new_question->question = $question;
      $new_question->option_1 = $option1;
      $new_question->option_2 = $option2;
      $new_question->option_3 = $option3;
      $new_question->option_4 = $option4;
      $new_question->option_5 = $option5;
      $new_question->right_ans = $request->right_ans;
      $new_question->related = $request->related;

      if ($new_question->save())
        return "ok";
      return "fail";

    }

    public function deleteQuestion(Request $request){
      $question = Question::find($request->id_question);
      if ($question->delete()) return "ok";
      return "fail";
    }

    public function newTeam(Request $request){
      try {
        $team = new Team;
        $team->name = $request->team_name;
        $team->email = $request->team_email;
        $team->phone = $request->team_phone;
        $team->type = $request->region;

        $team->save();

        $user = User::create([
          'name' => $request->team_name,
          'email' => $request->team_email,
          'password' => bcrypt($request->team_password),
          'role' => 3,
          'role_id' => $team->id_team
        ]);

        return "ok";

      } catch (\Exception $e) {
        return response()->json($e->getCode(), 500);
      }

      return "fail";
    }

    public function getTeamtoUpdate(Request $request){
      $user = User::where('role_id', $request->id_team)->select('name','email')->first();
      $team = Team::select('id_team','name','email','phone', 'type')->find($request->id_team);

      return response()->json([$user, $team]);
    }

    public function updateTeam(Request $request){
      $user = User::where('role_id', $request->team_id)->first();
      $team = Team::find($request->team_id);

      $team->name = $request->team_name;
      $team->email = $request->team_email;
      $team->phone = $request->team_phone;
      $team->type = $request->region;

      $user->name = $request->team_name;
      $user->email = $request->team_email;

      if ($request->team_password!='') {
        $user->password = bcrypt($request->team_password);
      }


      if ($user->save() && $team->save()) return "ok";
      return "fail";
    }

    public function listPdfPage(){
      return view('admin.generate-pdf');
    }

    public function getPacketsforPdf(){
      $packets = Packet::whereHas('questions')->get();
      return response()->json(['data'=>$packets]);
    }

    public function scoreBoardPage(){
      return view('admin.daftar-skor');
    }

    public function listPdf(Request $request, $id){

      $search_empty = 0;

      if (!empty($request->keywords)) {
        $pdfs = GeneratedPacket::where('id_packet', $id)
                ->where('packet_type', 'like', '%'.$request->keywords.'%')->orderBy('packet_type', 'asc')->paginate(12);
        if (!$pdfs->total()) {
          $search_empty = 1;
        }
      }

      else $pdfs = GeneratedPacket::where('id_packet', $id)->orderBy('packet_type', 'asc')->paginate(12);

      if ($request->ajax()) {
        return view('admin.partial-list-pdf', ['pdfs' => $pdfs, 'search_empty'=> $search_empty])->render();
      }

      return view('admin.list-pdf')->with('pdfs', $pdfs)->with('search_empty', $search_empty);
    }

    public function deletePdf(Request $request){
      $pdf = GeneratedPacket::find($request->id);
      $pdf->delete();
      unlink(storage_path('app/'.$pdf->packet_file_directory));
      return redirect()->back()->with('status', 'Penghapusan PDF berhasil!');
    }

    public function viewPdf($id){
      $pdf = GeneratedPacket::find($id);
      return response()->file(storage_path()."/app/".$pdf->packet_file_directory);
    }

    public function generateScore(Request $request){
      $team_packets = TeamPacket::where('id_packet', $request->id_packet)
                      ->where('final_score', null)->limit(100)->get();


      foreach ($team_packets as $tp) {
        $generated_packet = GeneratedPacket::find($tp->id_generated_packet);
        $team_ans = explode(',', $tp->team_ans);
        $questions_order = explode(',', $generated_packet->questions_order);

        $final_score = 0;

        for ($i=0; $i < sizeof($questions_order) - 1 ; $i++) {
          $q = Question::find($questions_order[$i]);
          if ($q->right_ans == $team_ans[$i]) {
            $final_score+=4;
          }elseif ($team_ans[$i] == 0){

          }else {
            $final_score-=1;
          }
        }

        $final_team_packet = TeamPacket::find($tp->id);
        $final_team_packet->final_score = $final_score;
        $final_team_packet->save();
      }

      return "ok";
    }

    public function getTeamScores(){
      $team_scores = TeamPacket::with(['teams', 'packets'])->where('final_score', '!=', null)->get();
      return response()->json(['data'=>$team_scores]);
    }

    public function generateScorePage(){
      return view('admin.generate-skor');
    }

    public function getPacketstoScore(){
      $packet_info = DB::table('packet')->select(DB::raw('count(team_packet.id) as number_of_scored_teams, packet.name, packet.id_packet'))
                  ->groupBy('id_packet')
                  ->orderBy('id_packet', 'asc')
                  ->where('final_score', '!=', null)
                  ->rightJoin('team_packet', 'packet.id_packet','=','team_packet.id_packet')
                  ->get();

      $no_of_teams_per_packet = DB::table('packet')->select(DB::raw('count(team_packet.id) as total_teams_per_packet, packet.name, packet.id_packet'))
                  ->groupBy('id_packet')
                  ->orderBy('id_packet', 'asc')
                  ->join('team_packet', 'packet.id_packet','=','team_packet.id_packet')
                  ->get();

      $data = array();
      $row = array();

      $idx = 0;

      foreach ($no_of_teams_per_packet as $n) {
        $row['total_teams_per_packet'] = $n->total_teams_per_packet;
        $row['packet_name'] = $n->name;
        $row['id_packet'] = $n->id_packet;
        if (isset($packet_info[$idx])) {
          $row['number_of_scored_teams'] = $packet_info[$idx]->number_of_scored_teams;
        }else {
          $row['number_of_scored_teams'] = 0;
        }
        $idx++;
        $data[] = $row;
      }

      return response()->json(['data'=>$data]);
    }

	public function downloadcsv(){

		Excel::create('Template CSV Tim', function($excel){

			// Set the spreadsheet title, creator, and description
			$excel->setTitle('Template CSV Tim');

			// Build the spreadsheet, passing in the payments array
			$excel->sheet('Tim', function($sheet){
				$sheet->fromArray(['id','name','email','phone'], null, 'A1', false, false);
			});

		})->download('csv');
	}

	public function uploadcsv(Request $r){
		if($r->hasFile('csv')){
			$r = $r->file('csv'); //This is the uploaded file
			Excel::filter('chunk')->load($r->path())->chunk(250, function($results){
				//Huge data can be overtime
				set_time_limit(0); //Prevent time limit
				foreach($results as $row){
					//Start adding the user
            $id = DB::table('team')->insertGetId([
              // 'id_team' => $row->get("id_team"),
              'name' => $row->get("name"),
              'email' => $row->get("email"),
              'phone' => $row->get("phone"),
              'type' => $row->get('type')
            ]);

            $user = new User;
            $user->name = $row->get('name');
            $user->email = $row->get('email');
            $user->password = bcrypt($row->get('email')."_".$row->get('type'));
            $user->role = 3;
            $user->role_id = $id;
            $user->save();
				}
				set_time_limit(30); //Restore time limit
			});
		}
		return redirect()->route("index.admin")->with('message', 'Import tim berhasil!');
	}

  public function assignTeamPage(){
    return view('admin.assign-teams');
  }

  public function getPacketsforAssign(){
    $packets = Packet::whereHas('generatedPackets')->get();
    return response()->json(["data"=>$packets]);
  }

  public function getTeamstoAssign(Request $request){
    $teams = Team::with(['teamPackets' => function($q) use ($request){
      $q->where('id_packet', $request->id_packet);
    }])->get();

    return response()->json(['data' => $teams]);
  }

  public function getTeamstoAssignPage(Request $request){
    $packet = Packet::find($request->id_packet);
    return view('admin.teams-to-assign', ['packet' => $packet]);
  }

  public function assignTeamtoPacket(Request $request){
    $team_ans='';
    $ans_stats='';

    $packet = Packet::find($request->id_packet);

    if ($packet->type == "warmup") {
      $packet->current_capacity = $packet->current_capacity + 1;
      $packet->save();
    }

    $assigned_packet = GeneratedPacket::where('id_packet', $packet['id_packet'])->inRandomOrder()->first();


    //cek kalo udah pernah diassign
    $team_packet = TeamPacket::where('id_packet', $request->id_packet)->where('id_team', $request->id_team)
                  ->first();

    if ($team_packet) {
      $team_packet->status = 1;
      $team_packet->has_finished = 0;
      //save in redis cache
      //format: id-packet_id-team_packet_id-type

      Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans', $team_packet->team_ans);
      Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat', $team_packet->ans_stats);

      if ($team_packet->save())
        return "ok";
      }

    //kalo gak bikin baru
    $team_packet = new TeamPacket;
    $team_packet->id_packet = $packet['id_packet'];
    $team_packet->id_generated_packet = $assigned_packet['id'];
    $team_packet->id_team = $request->id_team;
    $team_packet->packet_file_directory = $assigned_packet['packet_file_directory'];
    $team_packet->has_finished = 0;
    $team_packet->status = 1;

    //init jawaban tim
    for ($i=1; $i <=90 ; $i++) {
      $team_ans.= '0,';
      $ans_stats.='0,';
    }

    $team_packet->team_ans = $team_ans;
    $team_packet->ans_stats = $ans_stats;

    if ($team_packet->save())
      Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans', $team_packet->team_ans);
      Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat', $team_packet->ans_stats);
      return "ok";
    }

    public function assignAllOnline(Request $request){
      $teams = Team::where('type', 'Online')->get();

      $team_ans='';
      $ans_stats='';

      for ($i=1; $i <=90 ; $i++) {
        $team_ans.= '0,';
        $ans_stats.='0,';
      }

      for ($i=0; $i < $teams->count(); $i++) {
        $packet = Packet::find($request->id_packet);
        $assigned_packet = GeneratedPacket::where('id_packet', $packet['id_packet'])->inRandomOrder()->first();

        $team_packet = TeamPacket::where('id_packet', $request->id_packet)->where('id_team', $teams[$i]->id_team)
                      ->first();

        if ($team_packet) {
          $team_packet->status = 1;
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans', $team_packet->team_ans);
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat', $team_packet->ans_stats);
          $team_packet->save();
        }else {
          $team_packet = new TeamPacket;
          $team_packet->id_packet = $packet['id_packet'];
          $team_packet->id_generated_packet = $assigned_packet['id'];
          $team_packet->id_team = $teams[$i]->id_team;
          $team_packet->packet_file_directory = $assigned_packet['packet_file_directory'];
          $team_packet->has_finished = 0;
          $team_packet->status = 1;

          $team_packet->team_ans = $team_ans;
          $team_packet->ans_stats = $ans_stats;
          $team_packet->save();
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans', $team_packet->team_ans);
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat', $team_packet->ans_stats);
        }
      }
      if ($packet->type == "warmup") {
        $packet->current_capacity = $packet->current_capacity + $teams->count();
        $packet->save();
      }
      return "ok";
    }

    public function assignAllOffline(Request $request){
      $teams = Team::where('type', 'Offline')->get();

      $team_ans='';
      $ans_stats='';

      for ($i=1; $i <=90 ; $i++) {
        $team_ans.= '0,';
        $ans_stats.='0,';
      }

      for ($i=0; $i < $teams->count(); $i++) {
        $packet = Packet::find($request->id_packet);
        $assigned_packet = GeneratedPacket::where('id_packet', $packet['id_packet'])->inRandomOrder()->first();

        $team_packet = TeamPacket::where('id_packet', $request->id_packet)->where('id_team', $teams[$i]->id_team)
                      ->first();

        if ($team_packet) {
          $team_packet->status = 1;
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans', $team_packet->team_ans);
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat', $team_packet->ans_stats);
          $team_packet->save();
        }else {
          $team_packet = new TeamPacket;
          $team_packet->id_packet = $packet['id_packet'];
          $team_packet->id_generated_packet = $assigned_packet['id'];
          $team_packet->id_team = $teams[$i]->id_team;
          $team_packet->packet_file_directory = $assigned_packet['packet_file_directory'];
          $team_packet->has_finished = 0;
          $team_packet->status = 1;

          $team_packet->team_ans = $team_ans;
          $team_packet->ans_stats = $ans_stats;
          $team_packet->save();
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans', $team_packet->team_ans);
          Redis::set('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat', $team_packet->ans_stats);
        }

      }
      if ($packet->type == "warmup") {
        $packet->current_capacity = $packet->current_capacity + $teams->count();
        $packet->save();
      }
      return "ok";
    }

    public function unassignTeam(Request $request){
      $team_packet = TeamPacket::where('id_packet', $request->id_packet)->where('id_team', $request->id_team)
                    ->first();
      $packet = Packet::find($request->id_packet);

      Redis::del('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-ans');
      Redis::del('id-'.$team_packet->id_packet.'-'.$team_packet->id.'-stat');

      if ($packet->type == "warmup") {
        $packet->current_capacity = $packet->current_capacity -1 ;
        $packet->save();
      }
      $team_packet->status = 0;

      if ($team_packet->save()) {
        return "ok";
      }
    }

    public function unassignAll(Request $request){
      $team_packet = TeamPacket::where('id_packet', $request->id_packet)->where('status', 1)
                    ->update(['status' => 0]);
      $packet = Packet::find($request->id_packet);

      exec("redis-cli KEYS 'id-$request->id_packet-*'|xargs redis-cli DEL");

      // Redis::del('id-'.$request->id_packet.'-*-ans');
      // Redis::del('id-'.$request->id_packet.'-*-stat');

      if ($packet->type == "warmup")
        $packet->current_capacity = 0;
      $packet->save();
      return "ok";
    }

    public function duplicatePacket(Request $request){
      $old_packet = Packet::find($request->id_packet);
      $old_questions = Question::where('id_packet', $request->id_packet)->get();

      $new_packet = new Packet;

      $new_packet->name = $old_packet->name."_".uniqid();
      $new_packet->active_date = $old_packet->active_date;
      $new_packet->start_time = $old_packet->start_time;
      $new_packet->end_time = $old_packet->end_time;
      $new_packet->duration = $old_packet->duration;
      $new_packet->active = 0;

      $new_packet->save();

      for ($i=0; $i < $old_questions->count(); $i++) {
        $new_question = new Question;
        $new_question->id_packet = $new_packet->id_packet;
        $new_question->question = $old_questions[$i]->question;
        $new_question->option_1 = $old_questions[$i]->option_1;
        $new_question->option_2 = $old_questions[$i]->option_2;
        $new_question->option_3 = $old_questions[$i]->option_3;
        $new_question->option_4 = $old_questions[$i]->option_4;
        $new_question->option_5 = $old_questions[$i]->option_5;
        $new_question->right_ans = $old_questions[$i]->right_ans;
        $new_question->description = $old_questions[$i]->description;
        $new_question->related = $old_questions[$i]->related;
        $new_question->save();
      }
      return "ok";
    }

    public function settingsPage(){
      $user = Auth::user();
      return view('admin.settings', ['user'=>$user]);
    }
    public function updateUser(Request $request){
      $user = User::find($request->user_id);
      $user->name = $request->user_name;
      $user->email = $request->user_email;
      if ($request->user_password!='') {
        $user->password = bcrypt($request->user_password);
      }
      if ($user->save()) {
        return redirect()->back()->with('message', 'Info berhasil diperbaharui');
      }
    }

    public function deleteTeam(Request $request){
      $team = Team::find($request->id_team)->delete();
      $user = User::where('role_id', $request->id_team)->first()
              ->delete();
      return "ok";
    }

    public function announcementPage(){
      $a = Announcement::all();
      return view('admin.announcement')->with('announcements', $a);
    }

    public function announce(Request $request){
      $announcement = new Announcement;
      $announcement->content = $request->content;
      if ($announcement->save()) {
        return redirect()->back()->with('message', 'Pengumuman berhasil disimpan!');
      }
    }

    public function deleteAnnouncement(Request $request){
      $a = Announcement::find($request->id)->delete();
      return redirect()->back()->with('message', 'Pengumuman berhasil dihapus!');

    }

    public function getKloter(){
      $packets = Packet::with(['teamPackets' => function($q){
        $q->where('status', 0)->count();
      }])->get();
      return $packets;
    }

  }
