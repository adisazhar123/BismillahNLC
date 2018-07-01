<?php

namespace App\Http\Controllers;

use App;
use PDF;
use App\Question;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function index(){
      $questions = Question::where('id_packet', 1)->get();

      //return view('packet-pdf.template-pdf')->with('questions', $questions);

      $pdf = App::make('dompdf.wrapper');
      $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
      //$pdf->set_base_path(realpath('./'));
      $pdf->loadView('packet-pdf.template-pdf', array('questions' => $questions));
      return $pdf->stream();
      //return $pdf->stream();
    }
}
