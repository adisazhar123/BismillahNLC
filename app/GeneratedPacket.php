<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneratedPacket extends Model
{
  protected $table = 'generated_packet';
  protected $primaryKey = 'id';
  public $timestamps = false;


  public function packets(){
    return $this->belongsTo('App\Packet', 'id_packet', 'id_packet');
  }

}
