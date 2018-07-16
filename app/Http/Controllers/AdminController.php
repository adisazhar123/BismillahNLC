<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use App\Team;
use App\TeamPacket;
use App\Packet;
use App\Question;
use Carbon\Carbon;
use App\User;
use App\GeneratedPacket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    protected $server_time;

    public function __construct(){
      $this->server_time = Carbon::now('Asia/Jakarta')->toDateTimeString();
      View::share('server_time', $this->server_time);
    }

    //halaman index
    public function index(){
      return view('admin.daftar-teams');
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

       if ($packet->save())
        return "ok";

    }

    public function getPacketInfo(Request $request){
      $questions = Question::where('id_packet', $request->id_packet)->get();
      return response()->json($questions);
    }

    public function deletePacket(Request $request){
      $packet = Packet::find($request->id_packet);
      $questions = Question::where('id_packet', $request->id_packet);
      if($questions)
        if ($questions->delete() && $packet->delete())
        return "ok";
      elseif ($packet->delete())
        return "ok";
      return "false";
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
      $packet = Packet::select('id_packet','name','active_date', 'start_time', 'end_time', 'duration')->find($request->id_packet);
      return response()->json($packet);
    }

    public function updatePacket(Request $request){
      $packet = Packet::find($request->id_packet);
      $packet->name = $request->packet_name;
      $packet->active_date = $request->active_date;
      $packet->start_time = $request->start_time;
      $packet->end_time = $request->end_time;
      $packet->duration = $request->duration;
      $packet->active = 0;

      if ($request->hasFile('file')) {
        $file = $request->file('file');
        $contents = $file->openFile()->fread($file->getSize());
        $packet->file = $contents;
      }
       if ($packet->save()){
         return "ok";
       }
       return "fail";
    }


    public function statisticsPage(){
      return view('admin.statistics');
    }

    public function getPacketQuestions($id_packet){
      $questions = Question::where('id_packet', $id_packet)->get()->toArray();

      $data = array();
      $no = 1;
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
        $row[]= $no;
        $row[] = $question;
        $row[] = $button;
        $data[] = $row;
        $no++;
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
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->question, $data_question);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_1, $data_option1);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_2, $data_option2);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_3, $data_option3);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_4, $data_option4);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_5, $data_option5);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->description, $data_description);



      $question = $request->question;
      $option1 = $request->option_1;
      $option2 = $request->option_2;
      $option3 = $request->option_3;
      $option4 = $request->option_4;
      $option5 = $request->option_5;
      $description = $request->description;

      //Filter Math formulas
      if (isset($data_question[0]) && !empty($data_question[0])){
        $keep_question =  substr_replace($data_question[0], '/', 2, 0);
        $keep_question = substr_replace($keep_question, '/', 5, 0);

        //Utk di XAMPP
        $question = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_question[0], asset('storage/cache/'.$keep_question.'.png'), $request->question);
        //utk di php artisan serve
        $question = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_question[0], asset('storage/cache/'.$keep_question.'.png'), $question);
      }
      if (isset($data_option1[0]) && !empty($data_option1[0])){
        $keep_option1 =  substr_replace($data_option1[0], '/', 2, 0);
        $keep_option1 = substr_replace($keep_option1, '/', 5, 0);

        //Utk di XAMPP
        $option1 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option1[0], asset('storage/cache/'.$keep_option1.'.png'), $request->option_1);
        //utk di php artisan serve
        $option1 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option1[0], asset('storage/cache/'.$keep_option1.'.png'), $option1);
      }

      if (isset($data_option2[0]) && !empty($data_option2[0])){
         $keep_option2 =  substr_replace($data_option2[0], '/', 2, 0);
         $keep_option2 = substr_replace($keep_option2, '/', 5, 0);

        //Utk di XAMPP
        $option2 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option2[0], asset('storage/cache/'.$keep_option2.'.png'), $request->option_2);
        //utk di php artisan serve
        $option2 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option2[0], asset('storage/cache/'.$keep_option2.'.png'), $option2);
      }

      if (isset($data_option3[0]) && !empty($data_option3[0])){
        $keep_option3 =  substr_replace($data_option3[0], '/', 2, 0);
        $keep_option3 = substr_replace($keep_option3, '/', 5, 0);

        //Utk di XAMPP
        $option3 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option3[0], asset('storage/cache/'.$keep_option3.'.png'), $request->option_3);
        //utk di php artisan serve
        $option3 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option3[0], asset('storage/cache/'.$keep_option3.'.png'), $option3);
      }

      if (isset($data_option4[0]) && !empty($data_option4[0])){
        $keep_option4 =  substr_replace($data_option4[0], '/', 2, 0);
        $keep_option4 = substr_replace($keep_option4, '/', 5, 0);

        //Utk di XAMPP
        $option4 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option4[0], asset('storage/cache/'.$keep_option4.'.png'), $request->option_4);
        //utk di php artisan serve
        $option4 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option4[0], asset('storage/cache/'.$keep_option4.'.png'), $option4);
      }

      if (isset($data_option5[0]) && !empty($data_option5[0])){
        $keep_option5 =  substr_replace($data_option5[0], '/', 2, 0);
        $keep_option5 = substr_replace($keep_option5, '/', 5, 0);

        //Utk di XAMPP
        $option5 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option5[0], asset('storage/cache/'.$keep_option5.'.png'), $request->option_5);
        //utk di php artisan serve
        $option5 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option5[0], asset('storage/cache/'.$keep_option5.'.png'), $option5);
      }

      if (isset($data_description[0]) && !empty($data_description[0])){
        $keep_description =  substr_replace($data_description[0], '/', 2, 0);
        $keep_description = substr_replace($keep_description, '/', 5, 0);

        //Utk di XAMPP
        $description = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_description[0], asset('storage/cache/'.$keep_description.'.png'), $request->description);
        //utk di php artisan serve
        $description = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_description[0], asset('storage/cache/'.$keep_description.'.png'), $description);
      }



      //Filter image unisharp
      //utk di XAMPP
      $question = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $question);
      //utk PHP artisan serve
      $question = str_replace('/laravel-filemanager/app/public', asset('storage'), $question);

      $option1 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option1);
      //utk PHP artisan serve
      $option1 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option1);

      $option2 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option2);
      //utk PHP artisan serve
      $option2 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option2);

      $option3 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option3);
      //utk PHP artisan serve
      $option3 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option3);

      $option4 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option4);
      //utk PHP artisan serve
      $option4 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option4);

      $option5 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option5);
      //utk PHP artisan serve
      $option5 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option5);

      $description = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $description);
      //utk PHP artisan serve
      $description = str_replace('/laravel-filemanager/app/public', asset('storage'), $description);

      $question = Question::create([
        'id_packet' => $request->id_packet,
        'option_1' => str_replace('/laravel-filemanager/app/public', asset('storage'), $option1),
        'option_2' => str_replace('/laravel-filemanager/app/public', asset('storage'), $option2),
        'option_3' => str_replace('/laravel-filemanager/app/public', asset('storage'), $option3),
        'option_4' => str_replace('/laravel-filemanager/app/public', asset('storage'), $option4),
        'option_5' => str_replace('/laravel-filemanager/app/public', asset('storage'), $option5),
        'question' => str_replace('/laravel-filemanager/app/public', asset('storage'), $question),
        'right_ans' => $request->right_ans,
        'related' => $request->related,
        'description' => str_replace('/laravel-filemanager/app/public', asset('storage'), $description)
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
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->question, $data_question);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_1, $data_option1);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_2, $data_option2);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_3, $data_option3);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_4, $data_option4);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->option_5, $data_option5);
      preg_match("/(?<=\/js\/tinymce\/plugins\/tiny_mce_wiris\/integration\/showimage.php\?formula=)(\w*)/", $request->description, $data_description);



      $question = $request->question;
      $option1 = $request->option_1;
      $option2 = $request->option_2;
      $option3 = $request->option_3;
      $option4 = $request->option_4;
      $option5 = $request->option_5;
      $description = $request->description;


      //Filter Math formulas
      if (isset($data_question[0]) && !empty($data_question[0])){
        $keep_question =  substr_replace($data_question[0], '/', 2, 0);
        $keep_question = substr_replace($keep_question, '/', 5, 0);

        //Utk di XAMPP
        $question = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_question[0], asset('storage/cache/'.$keep_question.'.png'), $request->question);
        //utk di php artisan serve
        $question = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_question[0], asset('storage/cache/'.$keep_question.'.png'), $question);
      }
      if (isset($data_option1[0]) && !empty($data_option1[0])){
        $keep_option1 =  substr_replace($data_option1[0], '/', 2, 0);
        $keep_option1 = substr_replace($keep_option1, '/', 5, 0);

        //Utk di XAMPP
        $option1 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option1[0], asset('storage/cache/'.$keep_option1.'.png'), $request->option_1);
        //utk di php artisan serve
        $option1 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option1[0], asset('storage/cache/'.$keep_option1.'.png'), $option1);
      }

      if (isset($data_option2[0]) && !empty($data_option2[0])){
         $keep_option2 =  substr_replace($data_option2[0], '/', 2, 0);
         $keep_option2 = substr_replace($keep_option2, '/', 5, 0);

        //Utk di XAMPP
        $option2 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option2[0], asset('storage/cache/'.$keep_option2.'.png'), $request->option_2);
        //utk di php artisan serve
        $option2 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option2[0], asset('storage/cache/'.$keep_option2.'.png'), $option2);
      }

      if (isset($data_option3[0]) && !empty($data_option3[0])){
        $keep_option3 =  substr_replace($data_option3[0], '/', 2, 0);
        $keep_option3 = substr_replace($keep_option3, '/', 5, 0);

        //Utk di XAMPP
        $option3 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option3[0], asset('storage/cache/'.$keep_option3.'.png'), $request->option_3);
        //utk di php artisan serve
        $option3 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option3[0], asset('storage/cache/'.$keep_option3.'.png'), $option3);
      }

      if (isset($data_option4[0]) && !empty($data_option4[0])){
        $keep_option4 =  substr_replace($data_option4[0], '/', 2, 0);
        $keep_option4 = substr_replace($keep_option4, '/', 5, 0);

        //Utk di XAMPP
        $option4 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option4[0], asset('storage/cache/'.$keep_option4.'.png'), $request->option_4);
        //utk di php artisan serve
        $option4 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option4[0], asset('storage/cache/'.$keep_option4.'.png'), $option4);
      }

      if (isset($data_option5[0]) && !empty($data_option5[0])){
        $keep_option5 =  substr_replace($data_option5[0], '/', 2, 0);
        $keep_option5 = substr_replace($keep_option5, '/', 5, 0);

        //Utk di XAMPP
        $option5 = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option5[0], asset('storage/cache/'.$keep_option5.'.png'), $request->option_5);
        //utk di php artisan serve
        $option5 = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_option5[0], asset('storage/cache/'.$keep_option5.'.png'), $option5);
      }

      if (isset($data_description[0]) && !empty($data_description[0])){
        $keep_description =  substr_replace($data_description[0], '/', 2, 0);
        $keep_description = substr_replace($keep_description, '/', 5, 0);

        //Utk di XAMPP
        $description = str_replace('/bismillahNLC/public/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_description[0], asset('storage/cache/'.$keep_description.'.png'), $request->description);
        //utk di php artisan serve
        $description = str_replace('/js/tinymce/plugins/tiny_mce_wiris/integration/showimage.php?formula='.$data_description[0], asset('storage/cache/'.$keep_description.'.png'), $description);
      }




      //Filter image unisharp
      //utk di XAMPP
      $question = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $question);
      $question = str_replace('/bismillahNLC/public/storage', asset('storage'), $question);
      $question = str_replace('http://localhosthttp://localhost/bismillahNLC/public', url('/'), $question);
      $question = str_replace('http://127.0.0.1http://127.0.0.1/bismillahNLC/public', url('/'), $question);


      //utk PHP artisan serve
      $question = str_replace('/laravel-filemanager/app/public', asset('storage'), $question);


      $option1 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option1);
      $option1 = str_replace('/bismillahNLC/public/storage', asset('storage'), $option1);
      $option1 = str_replace('http://localhosthttp://localhost/bismillahNLC/public',  url('/'), $option1);
      $option1 = str_replace('http://127.0.0.1http://127.0.0.1/bismillahNLC/public',  url('/'), $option1);

      //utk PHP artisan serve
      $option1 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option1);

      $option2 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option2);
      $option2 = str_replace('/bismillahNLC/public/storage', asset('storage'), $option2);
      $option2 = str_replace('http://localhosthttp://localhost/bismillahNLC/public', url('/'), $option2);
      $option2 = str_replace('http://127.0.0.1http://127.0.0.1/bismillahNLC/public', url('/'), $option2);

      //utk PHP artisan serve
      $option2 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option2);

      $option3 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option3);
      $option3 = str_replace('/bismillahNLC/public/storage', asset('storage'), $option3);
      $option3 = str_replace('http://localhosthttp://localhost/bismillahNLC/public',  url('/'), $option3);
      $option3 = str_replace('http://127.0.0.1http://127.0.0.1/bismillahNLC/public',  url('/'), $option3);

      //utk PHP artisan serve
      $option3 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option3);

      $option4 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option4);
      $option4 = str_replace('/bismillahNLC/public/storage', asset('storage'), $option4);
      $option4 = str_replace('http://localhosthttp://localhost/bismillahNLC/public',  url('/'), $option4);
      $option4 = str_replace('http://127.0.0.1http://127.0.0.1/bismillahNLC/public',  url('/'), $option4);

      //utk PHP artisan serve
      $option4 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option4);

      $option5 = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $option5);
      $option5 = str_replace('/bismillahNLC/public/storage', asset('storage'), $option5);
      $option5 = str_replace('http://localhosthttp://localhost/bismillahNLC/public', url('/'), $option5);
      $option5 = str_replace('http://127.0.0.1http://127.0.0.1/bismillahNLC/public', url('/'), $option5);

      //utk PHP artisan serve
      $option5 = str_replace('/laravel-filemanager/app/public', asset('storage'), $option5);

      $description = str_replace('/bismillahNLC/public/laravel-filemanager/app/public', asset('storage'), $description);
      $description = str_replace('/bismillahNLC/public/storage', asset('storage'), $description);
      $description = str_replace('http://localhosthttp://localhost/bismillahNLC/public', url('/'), $description);
      $description = str_replace('http://127.0.0.1http://127.0.0.1/bismillahNLC/public', url('/'), $description);

      //utk PHP artisan serve
      $description = str_replace('/laravel-filemanager/app/public', asset('storage'), $description);


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
      $user = User::create([
        'name' => $request->team_name,
        'email' => $request->team_email,
        'password' => bcrypt($request->team_password),
        'phone' => $request->team_phone,
        'role' => 3
      ]);

      $team = new Team;
      $team->id_team = $user->id;
      $team->name = $request->team_name;
      $team->email = $request->team_email;
      $team->phone = $request->team_phone;

      if ($team->save())
        return "ok";
      return "fail";
    }

    public function getTeamtoUpdate(Request $request){
      $user = User::find($request->id_team);
      $team = Team::find($request->id_team);

      return response()->json([$user, $team]);
    }

    public function updateTeam(Request $request){
      $user = User::find($request->team_id);
      $team = Team::find($request->team_id);

      $team->id_team = $user->id;
      $team->name = $request->team_name;
      $team->email = $request->team_email;
      $team->phone = $request->team_phone;

      $user->name = $request->team_name;
      $user->email = $request->team_email;
      $user->password = bcrypt($request->team_password);

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
                      ->where('final_score', null)->limit(10)->get();

      foreach ($team_packets as $tp) {
        $generated_packet = GeneratedPacket::find($tp->id_generated_packet);

        $team_ans = explode(',', $tp->team_ans);
        $questions_order = explode(',', $generated_packet->questions_order);

        $final_score = 0;

        for ($i=0; $i < 90 ; $i++) {
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
		return "will download now";
	}
	
	public function uploadcsv(Request $r){
		if($r->hasFile('csv')){
			$r = $r->file('csv'); //This is the uploaded file
			return "ok";
		}else{
			return "fail";
		}
	}
}
