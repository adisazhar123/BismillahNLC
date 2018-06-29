<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Packet;
use App\Question;
use App\User;

class AdminController extends Controller
{
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

      for ($x=0; $x<count($questions); $x++) {
        $question = $questions[$x]['question'];
        $id_question = $questions[$x]['id_question'];
        $question .= "<ol type='A'>";
          for ($i=1; $i <=5 ; $i++) {
            if ($i == $questions[$x]['right_ans']) {
              $question .= "<strong><li>".$questions[$x]['option_'.$i]."</li></strong>";
            }else{
              $question .= "<li>".$questions[$x]['option_'.$i]."</li>";
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
      return $request->all();
      $question = Question::create([
        'id_packet' => $request->id_packet,
        'option_1' => $request->option_1,
        'option_2' => $request->option_2,
        'option_3' => $request->option_3,
        'option_4' => $request->option_4,
        'option_5' => $request->option_5,
        'question' => $request->question,
        'right_ans' => $request->right_ans,
        'related' => $request->related,
        'description' => $request->description
      ]);
      return "ok";
    }

    public function updateQuestion(Request $request){
      $question = Question::find($request->id_question);

      $question->description = $request->description;
      $question->question = $request->question;
      $question->option_1 = $request->option_1;
      $question->option_2 = $request->option_2;
      $question->option_3 = $request->option_3;
      $question->option_4 = $request->option_4;
      $question->option_5 = $request->option_5;
      $question->right_ans = $request->right_ans;
      $question->related = $request->related;

      if ($question->save())
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

      // $team->id_team = $user->id;
      // $team->name = $request->team_name;
      // $team->email = $request->team_email;
      //
      // $user->name = $request->team_name;
      // $user->email = $request->team_email;
      // $user->password = bcrypt($request->team_password);

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
}
