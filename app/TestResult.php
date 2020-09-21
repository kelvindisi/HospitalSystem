<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $guarded = [];

    public function test_request()
    {
        return $this->belongsTo('App\TestRequest');
    }
}
