<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'tb_transaksi';

    public function agenda(){
        return $this->belongsTo('App\Agenda', 'id_agenda', 'id');
    }

    public function pictures(){
        return $this->hasMany('App\Pictures', 'laporan_id', 'id');
    }
}
