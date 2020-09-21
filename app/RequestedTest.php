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
    public function test_result()
    {
        return $this->hasOne('App\TestResult');
    }
    public function test_invoice()
    {
        return $this->hasOne('App\TestInvoice');
    }
}
