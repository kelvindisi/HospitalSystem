<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultationInvoice extends Model
{
    protected $guarded = [];

    public function consultation()
    {
        return $this->belongsTo('App\Consultation');
    }
}
