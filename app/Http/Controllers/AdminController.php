<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Packet;
use App\Question;

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

       $file = $request->file('file');
       $contents = $file->openFile()->fread($file->getSize());
       $packet->file = $contents;

       $packet->save();
       //init question & answers
       for ($i=1; $i <= 90 ; $i++) {
         $question = new Question;
         $question->question_no = $i;
         $question->id_packet = $packet->id_packet;
         $question->save();
       }

       return "ok";

    }

    public function getPacketInfo(Request $request){
      $questions = Question::where('id_packet', $request->id_packet)->get();
      return response()->json($questions);
    }

    public function deletePacket(Request $request){
      $packet = Packet::find($request->id_packet);
      $questions = Question::where('id_packet', $request->id_packet);
      if ($packet->delete() && $questions->delete())
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
}
