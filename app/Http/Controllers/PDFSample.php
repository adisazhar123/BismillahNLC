<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App; //Pakai Class ini!!!!
use PDF; //Pakai Class ini!!!!

class PDFSample extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		/**
		 * Tutorial di 
		 * https://github.com/barryvdh/laravel-dompdf
		 * http://www.expertphp.in/article/generate-pdf-from-html-in-php-laravel-using-dompdf-library
		 */
		
		$pdf = App::make('dompdf.wrapper');
		
		//This is how to load image from Public directory
		//Real image located under public/img/sample.jpg
		$pdf->loadHTML("<h1>hello</h1><br><img height='100' src='img/sample.jpg'>");
		return $pdf->stream();
		
		//return PDF::loadHTML("<h1>hello</h1>")->setPaper('a4', 'landscape')->setWarnings(false)->stream();
		//return PDF::loadHTML("<h1>hello</h1>")->setPaper('a4', 'landscape')->setWarnings(false)->download();
    }
}
