<?php

namespace App\Models;

use  \Illuminate\Database\Eloquent\Model;

class Dentista extends Model
{
    protected $table    = 'dentists';
    protected $fillable = [
                            'cpf','email','name','gender','date_of_birth','rg','agency',
                            'marital_status_id','nationality','place_of_birth','address_postcode','address_address', 
                            'address_number', 'address_secondary_address', 'address_city', 'address_state'
                          ];


    public function phones()
    {
        return $this->hasMany('App\Models\TelefoneDentista', 'dentist_id');
    }

    public function marital()
    {
        return $this->belongsTo('App\Models\EstadoCivil', 'marital_status_id');
    }

   

}