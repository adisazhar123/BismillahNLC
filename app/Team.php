<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
  protected $table = 'team';
  protected $primaryKey = 'id_team';
  public $timestamps = false;

  public function teamPackets(){
    return $this->hasMany('App\TeamPacket', 'id_team', 'id_team');
  }
}
