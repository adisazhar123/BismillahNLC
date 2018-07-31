<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamPacket extends Model
{
  protected $table = 'team_packet';
  protected $primaryKey = 'id';
  //iki tak tambahi gawe firstornew mass assignment
  protected $guarded = [''];
  public $timestamps = false;

  public function packets(){
    return $this->belongsTo('App\Packet', 'id_packet', 'id_packet');
  }
  public function teams(){
    return $this->belongsTo('App\Team', 'id_team', 'id_team');
  }
}
