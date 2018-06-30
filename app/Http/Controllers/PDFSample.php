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
		$data = [
			"soal" => [
				//Berikut contoh data soal
				[
					"Terdapat 16 tim dalam sebuah turnamen sepak bola mini. Jika setiap satu tim melawan tim yang lainnya tepat satu kali, maka berapa banyak pertandingan yang akan dilangsungkan pada turnamen tersebut?",
					["32","60","100","120","200"]
				],
				[
					"Jika kemarin lusa adalah Kamis dan deadline dari tugasmu adalah 5 hari kemudian setelah hari ini, maka pada hari apakah tugasmu tidak dapat dikumpulkan?",
					["Jumat","Sabtu","Minggu","Senin","Selasa"]
				],
				[
					"Sebuah kantong yang mengandung uang recehan sebanyak sepuluh uang $100, sepuluh uang $200, dan sepuluh uang $300. Mata anda ditutup dan anda boleh mengambil satu uang dari kantong tersebut secara bergantian dan pengambilan akan berhenti ketika ia mengambil tiga uang dari salah satu besaran uang yang sama. Anda boleh menyimpan hasil dari pengambilan tersebut sampai anda diminta untuk berhenti. Berapakah jumlah terbesar dari uang yang anda miliki dari pengambilan tersebut?",
					["$900","$1,100","$1,300","$1,500","$1,700"]
				],
				
				//Coba pakai page-break kalau ada soal yang kepotong
				["page-break"],
				
				[
					"Tabel berikut untuk tiga soal berikutnya.<br><img height='200' src='".storage_path("soal/tabel1.png")."'>"
				],
				[
					"Perhatikan soal berikut!<br><img height='200' src='".storage_path("soal/soal1.png")."'><br>Berapa banyak jumlah segitiga yang ada dalam gambar tersebut?",
					["0 <= jumlah <= 29","30<= jumlah <= 49","50<= jumlah <=69", "70<= jumlah <=89","90<= jumlah <=109"]
				],
				["page-break"],
				
				//Contoh deskripsi panjang
				[
					"Deskripsi berikut untuk tiga soal berikutnya.<br><br>
					Suatu malam Elsi sedang bermimpi. Dia mendapati dirinya sedang berada di dalam sebuah gedung. Ketika dia di dalam ruang Tiga ia dapat turun dua lantai dan berjalan ke kiri, dan sekarang ia berada di ruang delapan. Ketika ia di ruang Dua, ia turun tiga lantai dan tiba di ruangan dasar / ruang utama lalu berjalan ke kiri dan mendapati dirinya sedang berada dalam ruangan yang penuh dengan bintang. Ketika ia berada di ruangan dasar / ruangan utama, ia berjalan ke kanan lalu masuk ke dalam ruangan yang penuh dengan pagar. Dari ruangan itu ia naik dan sampai ke ruang Tiga. Jika ia berada di ruang Sembilan dan ingin pergi ke ruang Satu, maka ia perlu naik dua lantai dan melewati tiga ruangan sebelum mencapai ruang Satu. Elsi tahu hanya ada tiga ruangan pada tiap-tiap lantai di gedung tersebut."
				],
				[
					"Jika Elsi sekarang ada di ruang Lima, ruang apa saja yang akan ia temukan jika ia naik?",
					["Ruang Satu, ruang Dua, ruang Tiga","Ruang Dua, ruang Tiga, ruang Empat","Ruang Enam, ruang Tujuh, ruang Delapan","Ruang Tujuh, ruang Delapan, ruang Sembilan","Tidak ada, karena Elsi sudah berada di lantai paling atas."]
				]
			]
		];

		$pdf = PDF::loadView("soal",$data); 	//File template ada di soal.blade.php		
		return $pdf->stream();
    }
}
