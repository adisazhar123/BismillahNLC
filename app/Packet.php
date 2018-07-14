<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    protected $table = 'packet';
    protected $primaryKey = 'id_packet';
    public $timestamps = false;

    public function questions(){
      return $this->hasMany('App\Question', 'id_packet', 'id_packet');
    }

    public function generatedPackets(){
      return $this->hasMany('App\GeneratedPacket', 'id_packet', 'id_packet');
    }

    public function teamPackets(){
      return $this->hasMany('App\TeamPacket', 'id_packet', 'id_packet');
    }
}
