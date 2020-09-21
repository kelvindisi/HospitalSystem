<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrescriptionInvoice extends Model
{
    protected $guarded = [];

    // Relationships
    public function prescription()
    {
        return $this->belongsTo('App\Prescription');
    }
    public function test_invoice()
    {
        return $this->hasOne('App\TestInvoice');
    }
}
