<?php

namespace App\Http\Controllers;

use App;
use PDF;
use Storage;
use App\GeneratedPacket;
use App\Question;
use App\Packet;
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
      $packet = Packet::find($request->id_packet);


      //Bikin sebanyak PDF packet_count
      for ($i=0; $i < $request->packet_count; $i++) {
        $generated_packet = new GeneratedPacket;
        $nama_file='';
        $questions_order='';

        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);

        if ($request->randomize === '0') { //Utk paket yang gak acak soal
          $pdf->loadView('packet-pdf.template-pdf', array('questions' => $questions));
          $nama_file = "public/paket_soal/".str_random(5).".pdf";
          Storage::put($nama_file, $pdf->output());
          unset($pdf);


          foreach ($questions as $q) {
            $questions_order.=$q->id_question.',';
          }

          $generated_packet->id_packet = $request->id_packet;
          $generated_packet->packet_type = $packet->name."_".substr(uniqid('', true), -4);
          $generated_packet->questions_order = $questions_order;
          $generated_packet->packet_file_directory = $nama_file;
          $generated_packet->shuffle = 0;
          $generated_packet->save();


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
              $questions_order.=$my_questions->id_question.',';
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


          foreach ($related as $r) {
            $questions_order.=$r->id_question.',';
          }

          $nama_file = "public/paket_soal/".str_random(5).".pdf";
          $pdf->loadView('packet-pdf.template-pdf-random', array('related' => $related, 'non_related'=>$non_related));
          Storage::put($nama_file, $pdf->output());
          unset($pdf);

          $generated_packet->id_packet = $request->id_packet;
          $generated_packet->packet_type = $packet->name."_".substr(uniqid('', true), -4);
          $generated_packet->questions_order = $questions_order;
          $generated_packet->packet_file_directory = $nama_file;
          $generated_packet->shuffle = 1;
          $generated_packet->save();

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
