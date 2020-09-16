<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $guarded = [];

    public function drug()
    {
        return $this->belongsTo('App\Drug');
    }
    public function consultation()
    {
        return $this->belongsTo('App\Consultation');
    }
}
