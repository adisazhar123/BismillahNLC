<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
  protected $table = 'team';
  protected $primaryKey = 'id_team';
  public $timestamps = false;
}
