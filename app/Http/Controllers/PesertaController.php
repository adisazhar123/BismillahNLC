<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function showLogin(){
      return view('peserta.login');
    }

    public function showExam(){
      return view('peserta.home');
    }

    public function showPetunjuk(){
      return view('peserta.petunjuk');
    }
}
