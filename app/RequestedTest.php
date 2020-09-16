<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestedTest extends Model
{
    protected $guarded = [];

    
    // Relationships
    public function consultation()
    {
        return $this->belongsTo('App\Consultation');
    }
    public function test()
    {
        return $this->belongsTo('App\Test');
    }
}
