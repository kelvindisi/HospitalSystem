<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consultation;
use App\Prescription;
use App\PrescriptionInvoice;

class PharmacyController extends Controller
{
    public function index()
    {
        return view('pharmacy.dashboard');
    }

    public function pending()
    {
        $consultations = $this->consultationsWithPrescriptions();
        $pending = $this->getByAvailability($consultations, 'pending');
        
        return view('pharmacy.prescription_list')->with(['consultations' => $pending]);
    }

    public function details(Request $request, Consultation $consultation)
    {
        return view('pharmacy.details_prescriptions', ['consultation' => $consultation]);
    }

    public function processed(Request $request, Consultation $consultation)
    {
        return view('pharmacy.details_processed_prescriptions', ['consultation' => $consultation]);
    }
    public function issueProcess(Request $request, Prescription $prescription)
    {
        if ($prescription->consultation->status != "seen")
            return redirect()->back()->with('message', 'Doctor has not concluded the consultation yet.');
        $prescription->issued = !$prescription->issued;
        $prescription->save();
        return redirect()->back()->with('success', 'Updated prescription issue details successfully');
    }

    public function issued()
    {
        $consultation_ids = [];
        $consultations = [];
        $prescriptions = Prescription::where('issued', true)->get();
        foreach($prescriptions as $prescription)
        {
            if(!in_array($prescription->consultation->id, $consultation_ids))
            {
                array_push($consultation_ids, $prescription->consultation->id);
                array_push($consultations, $prescription->consultation);
            }
        }
        return view('pharmacy.prescription_processed_list', ['consultations' => $consultations]);
    }

    public function unpaid()
    {
        $un_paid  = [];
        
        $add = true;
        $consultations = $this->consultationsWithPrescriptions();

        foreach($consultations as $consultation)
        {
            $prescriptions = $consultation->prescriptions;
            foreach($prescriptions as $prescription)
            {
                if($prescription->prescription_invoice)
                {
                    $invoice = $prescription->prescription_invoice;

                    if($invoice->paid != "no" )
                        $add = false;
                }

                if ($add)
                    array_push($un_paid, $consultation);
                else
                    $add = true;
            }
        }
        
        return view('pharmacy.prescription_list')->with(['consultations' => $un_paid]);
    }
    
    public function paid()
    {
        $paid  = [];
        
        $add = true;
        $consultation_ids = [];
        $consultations = $this->consultationsWithPrescriptions();

        foreach($consultations as $consultation)
        {
            $prescriptions = $consultation->prescriptions;
            foreach($prescriptions as $prescription)
            {
                $allIssued = true;
                if($prescription->prescription_invoice)
                {
                    $invoice = $prescription->prescription_invoice;
                    if ($prescription->issued != true)
                        $allIssued = false;

                    if($invoice->paid != "yes")
                        $add = false;
                }

                if ($add && !$allIssued)
                {
                    if(!in_array($consultation->id, $consultation_ids))
                        array_push($paid, $consultation);
                    array_push($consultation_ids, $consultation->id);
                }
                else
                    $add = true;
            }
        }
        
        return view('pharmacy.prescription_processed_list')->with(['consultations' => $paid]);
    }

    // prescription management
    public function prescriptionAvaila(Request $request, Prescription $prescription)
    {
        if ($this->createPrescriptionInvoice($prescription))
        {
            $prescription->availability = 'yes';
            $prescription->save();
            return redirect()->back()->with('message', 'Prescription approved for payment.');
        }
        return redirect()->back()->with('error', 'Error occured while approving prescription for payment.');
    }

    public function prescriptionNotAvaila(Request $request, Prescription $prescription)
    {
        if (!$this->prescriptionHasInvoice($prescription))
        {
            if ($this->createPrescriptionInvoice($prescription))
            {
                $prescription->availability = 'yes';
                $prescription->save();
                $msg = "Prescription had no invoice to enable payment one has been created, try again.";
                return redirect()->back()->with('message', $msg);
            }
            $prescription->availability = "pending";
            $prescription->save();
            return redirect()->back()->with('warning', 'Prescription has no invoice, retry again');
        }
        if ($this->removePrescriptionInvoice($prescription))
        {
            $prescription->availability = 'no';
            $prescription->save();
            return redirect()->back()->with('message', 'Prescription removed from payment list.');
        }
        return redirect()->back()->with('error', 'Prescription maybe already be paid for.');
    }

    // common functions
    private static function getByPaidAvailability($consultations, $paid, $availability)
    {
        $consultationByStatus = [];
        foreach($consultations as $consultation)
        {
            $prescriptions = $consultation->prescriptions;
            $add = false;

            foreach($prescriptions as $prescription)
            {
                $paid  = $prescription->paid == $paid? true:false;
                $availability  = $prescription->availability == $availability? true:false;

                if ($paid && $availability)
                {
                    $add = true;
                    break;
                }
            }

            if ($add)
            {
                array_push($consultationByStatus, $consultation);
                $add = false;
            }
        }
        return $consultationByStatus;
    }
    private static function getByAvailability($consultations, $availability)
    {
        $consultationByStatus = [];
        foreach($consultations as $consultation)
        {
            $prescriptions = $consultation->prescriptions;
            $add = false;

            foreach($prescriptions as $prescription)
            {
                $availability  = $prescription->availability == $availability? true:false;

                if ($availability)
                {
                    $add = true;
                    break;
                }
            }

            if ($add)
            {
                array_push($consultationByStatus, $consultation);
                $add = false;
            }
        }
        return $consultationByStatus;
    }

    public static function consultationHasPrescription($consultation)
    {
        if ($consultation->prescriptions->count() > 0)
            return true;
        else
            return false;
    }
    
    public static function consultationsWithPrescriptions()
    {
        $withPrescriptions = [];
        $consultations = Consultation::all();
        foreach($consultations as $consultation)
        {
            if ($consultation->prescriptions->count() > 0)
                array_push($withPrescriptions, $consultation);
        }

        return $withPrescriptions;
    }
    
    public static function prescriptionHasInvoice($prescription)
    {
        if ($prescription->prescription_invoice)
        {
            return true;
        } else {
            return false;
        }
    }
    
    private function createPrescriptionInvoice($prescription)
    {
        if ($prescription->prescription_invoice)
            return false;
        $amount = $prescription->drug->price;
        
        $data = [
            'amount' => $amount,
            'prescription_id' => $prescription->id
        ];

        $presInvoice = PrescriptionInvoice::create($data);
        return $presInvoice;
    }
    private function removePrescriptionInvoice($prescription)
    {
        $presInvoice = PrescriptionInvoice::where('prescription_id', $prescription->id)->first();
        if ($presInvoice)
        {
            if ($presInvoice->paid == 'pending')
            {
                $presInvoice->delete();
                return true;
            }
            return false;
        }
        return false;
    }
    
}
