<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'tb_konten_agenda';

    public function User(){
        return $this->belongsTo('App\User');
    }

    public function laporan(){
        return $this->hasOne('App\Laporan', 'id_agenda');
    }
}
