<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'guide_id', 'day', 'time_begin', 'time_end',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function route() {
        return $this->hasOne('App\Route');
    }
}
