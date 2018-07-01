<?php

namespace App\Http\Controllers;

use App;
use PDF;
use Storage;
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

    //Fungsi untuk generate pake soal menjadi PDF.
    public function generatePDF(Request $request){
      $pdf = App::make('dompdf.wrapper');
      $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

      $questions = Question::where('id_packet', $request->id_packet)->get();

      //Bikin sebanyak PDF packet_count
      for ($i=0; $i < $request->packet_count; $i++) {
        if ($request->randomize === '0') { //Utk paket yang gal acak soal
          $pdf->loadView('packet-pdf.template-pdf', array('questions' => $questions));
          Storage::put("public/paket_soal/".str_random(5).".pdf", $pdf->output());
          return "ok";
        }else{  //Utk yang gak acak soal
          return "acak";
        }
      }
    }
}
