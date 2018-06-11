<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

      protected $table = 'questions';
      protected $primary_key = 'id_question';
      public $timestamps = false;
}
