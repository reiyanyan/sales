<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pictures extends Model
{
    protected $table = 'tb_pictures';
    
    public function laporan(){
        return $this->belongsTo('App\Laporan');
    }
}
