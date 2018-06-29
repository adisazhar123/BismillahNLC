<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'id_question';
    public $timestamps = false;
    protected $fillable = ['id_packet','option_1', 'option_2', 'option_3', 'option_4', 'option_5', 'question', 'right_ans', 'related', 'description'];

    public function packet(){
      return $this->belongsTo('App\Packet', 'id_packet', 'id_packet');
    }
}
