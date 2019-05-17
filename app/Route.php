<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function appointment() {
        return $this->belongTo('App\Appointment');
    }
}
