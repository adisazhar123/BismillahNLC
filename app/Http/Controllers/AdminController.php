<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Packet;

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
      $packets = Packet::all();
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

      if ($packet->save()) return "ok";
      return "false";

    }

    public function deletePacket(Request $request){
      $packet = Packet::find($request->id_packet);

      if ($packet->delete())
        return "ok";
      return "false";
    }
}
