<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamAnswer extends Model
{
  protected $table = 'team_answer';
  protected $primary_key = 'id';
  public $timestamps = false;
}
