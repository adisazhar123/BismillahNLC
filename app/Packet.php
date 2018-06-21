<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    protected $table = 'packet';
    protected $primaryKey = 'id_packet';
    public $timestamps = false;
}
