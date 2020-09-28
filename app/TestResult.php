<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $guarded = [];

    public function requested_test()
    {
        return $this->belongsTo('App\RequestedTest');
    }
}
