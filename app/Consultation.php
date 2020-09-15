<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Invoice;

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
        $mode = PaymentMode::find($consultation->paymentmode_id)->first();
        if ($mode)
        {
            $data = [
                'consultation_id' => $consultation->id,
                'amount' => $mode->consultation_fee,
            ];
            if (!Invoice::create($data))
                $consultation->delete();

        } else {
            $consultation->delete();
        }
        

    }
}
