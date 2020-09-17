<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ConsultationInvoice;

class Consultation extends Model
{
    protected $guarded = [];

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($consultation) {
            \App\Consultation::createInvoice($consultation);
        });
    }

    private static function createInvoice($consultation)
    {
        $mode = PaymentMode::find($consultation->payment_mode_id);
        if ($mode)
        {
            $data = [
                'consultation_id' => $consultation->id,
                'amount' => $mode->consultation_fee
            ];
            if (!ConsultationInvoice::create($data))
                $consultation->delete();

        } else {
            $consultation->delete();
        }
    }

    // Relationship
    public function consultation_invoice()
    {
        return $this->hasOne('App\ConsultationInvoice');
    }
    public function requested_tests()
    {
        return $this->hasMany('App\RequestedTest');
    }
    public function prescriptions()
    {
        return $this->hasMany('App\Prescription');
    }
}
