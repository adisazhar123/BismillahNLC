<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function showLogin(){
      return view('peserta.login');
    }

    public function showExam(){
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
}
