<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $guarded = [];

    // Relationship

    public function prescriptions()
    {
        return $this->hasMany('App\Prescription');
    }
}
