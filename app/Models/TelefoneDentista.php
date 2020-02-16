<?php

namespace App\Models;

use  \Illuminate\Database\Eloquent\Model;

class TelefoneDentista extends Model
{
    protected $table = 'phones_dentist';
    protected $fillable = ['type','number','dentist_id'];

    public    $timestamps = false;

    public function dentista()
    {
        return $this->belongsTo('App\Models\Dentista', 'dentist_id');
    }
}