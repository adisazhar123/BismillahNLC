<?php

namespace App\Http\Controllers;

use App\Packet;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function showLogin(){
      return view('peserta.login');
    }

    public function showExam(){
      $team_ans="";
      $question_id="";
      // $team_answer = TeamAnswer::where('id_team', Auth::user()->id)->get();
      // if($team_answer->isEmpty()){
      //   $team_answer = new TeamAnswer;
      //   $team_answer->id_team = Auth::user()->id;
      //   $team_answer->id_packet = 2;
      //   for ($i=1; $i <=90 ; $i++) {
      //     $team_ans.= '0,';
      //     $question_id .= $i.' ';
      //   }
      //   $question_id = str_replace(' ', ',', $question_id);
      //   $team_answer->team_ans = $team_ans;
      //   $team_answer->id_question = $question_id;
      //   $team_answer->save();
      // }
      return view('peserta.ujian');
    }

    public function showPetunjuk(){
      return view('peserta.petunjuk');
    }

    public function home(){
      return view('peserta.home');
    }

    public function showWelcome(){
      return view('peserta.welcome-peserta');
    }

    public function submitAns(Request $request){
      return response()->json($request->all());
    }

    public function submitAnsStat(Request $request){
      return response()->json($request->all());
    }

    public function getQuestions(){
      $questions = Question::all();
      return $questions;
    }
}
