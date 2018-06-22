<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamPacket extends Model
{
  protected $table = 'team_packet';
  protected $primaryKey = 'id';
  public $timestamps = false;
}
