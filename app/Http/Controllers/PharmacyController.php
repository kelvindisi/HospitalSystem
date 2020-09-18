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

    public function unpaid()
    {
        $consultations = $this->consultationsWithPrescriptions();
        $pending = $this->getByPaidAvailability($consultations, 'pending', 'yes');
        
        return view('pharmacy.prescription_list')->with(['consultations' => $pending]);
    }
    
    public function paid()
    {
        $consultations = $this->consultationsWithPrescriptions();
        $pending = $this->getByStatusAvailability($consultations, 'yes', 'yes');
        
        return view('pharmacy.prescription_list')->with(['consultations' => $pending]);
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
        return redirect()->back()->with('message', 'Failed to remove prescription from payment list, try again.');
    }

   
    // Availability - availability - yes, no, pending
    // Status - paid - yes, no, pending

    // common functions
    
    private function getByPaidAvailabilityIssued($consultations, $paid, $availability, $issued)
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
                $issued  = $prescription->issued == $issued? true:false;

                if ($paid && $availability && $issued)
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
    private function getByPaidAvailability($consultations, $paid, $availability)
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
    private function getByAvailability($consultations, $availability)
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
    
    private function consultationsWithPrescriptions()
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
    private function getConsultation($id)
    {
        return Consultation::find($id);
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
    
    private function prescriptionHasInvoice($prescription)
    {
        if ($prescription->prescription_invoice)
        {
            return true;
        } else {
            return false;
        }
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
