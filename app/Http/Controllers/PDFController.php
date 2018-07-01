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


      $questions = Question::where('id_packet', $request->id_packet)->get();

      //Bikin sebanyak PDF packet_count
      for ($i=0; $i < $request->packet_count; $i++) {
        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        if ($request->randomize === '0') { //Utk paket yang gak acak soal
          $pdf->loadView('packet-pdf.template-pdf', array('questions' => $questions));
          Storage::put("public/paket_soal/".str_random(5).".pdf", $pdf->output());
          unset($pdf);
        }else{  //Utk yang acak soal
          //Array related untuk menyimpan soal cerita/ berhubungan
          //Array non_related untuk menyimpan soal yg tidak berhubungan
          $non_related = array();
          $related = array();

          $randomized_questions = $questions->shuffle();
          $randomized_questions->all();

          foreach ($randomized_questions as $my_questions) {
            if ($my_questions->related == 0) {
              $non_related[] = $my_questions;
            }else{
              $related[] = $my_questions;
            }

          }

          usort($related, function($a, $b){
            if ($a['id_question'] < $b['id_question']) {
              return -1;
            }else {
              return 1;
            }
          });

          $pdf->loadView('packet-pdf.template-pdf-random', array('related' => $related, 'non_related'=>$non_related));
          Storage::put("public/paket_soal/".str_random(5).".pdf", $pdf->output());
          unset($pdf);
        }
      }
      return "ok";
    }

    public function compare($ar1, $ar2){
      if ($ar1['id_question']<$ar2['id_question']) {
        return 1;
      }else {
        return -1;
      }
    }
}
