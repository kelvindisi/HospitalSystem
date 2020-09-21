<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestInvoice extends Model
{
    protected $guarded = [];

    public function requested_test()
    {
        return $this->belongsTo('App\RequestedTest');
    }
}
