<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    protected $table = 'packet';
    protected $primary_key = 'id_packet';
    public $time_stamps = false;
}
