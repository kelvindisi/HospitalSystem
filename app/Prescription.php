<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $guarded = [];

    // Relationship
    
    public function drug()
    {
        return $this->belongsTo('App\Drug');
    }
    public function consultation()
    {
        return $this->belongsTo('App\Consultation');
    }
    public function prescription_invoice()
    {
        return $this->hasOne('App\PrescriptionInvoice');
    }
}
