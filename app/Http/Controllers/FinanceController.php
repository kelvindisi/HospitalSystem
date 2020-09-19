<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConsultationInvoice;
use App\Consultation;
use App\Http\Controllers\PharmacyController;
use App\PrescriptionInvoice;

class FinanceController extends Controller
{
    public function index()
    {
        return view('finance.dashboard');
    }
    public function ConsultationInvoices()
    {
        $invoices = ConsultationInvoice::where('paid', 'pending')->latest()->get();

        return view('finance.consultation_invoices')->with(['invoices' => $invoices]);
    }
    public function ConsultationPaidInvoices()
    {
        $invoices = ConsultationInvoice::where('paid', 'yes')->latest()->get();

        return view('finance.consultation_invoices')->with(['invoices' => $invoices]);
    }
    public function ConsultationNotPaidInvoices()
    {
        $invoices = ConsultationInvoice::where('paid', 'no')->latest()->get();

        return view('finance.consultation_invoices')->with(['invoices' => $invoices]);
    }
    public function ConsultationInDetails(Request $request, ConsultationInvoice $invoice)
    {
        return view('finance.consultationInvoice_details')->with(['invoice' => $invoice]);
    }
    public function ConInStatusUpdate(Request $request, ConsultationInvoice $invoice)
    {
        $status = strtolower($request->validate(['status' => 'required|string'])['status']);

        $statusOptions = ['pending', 'yes', 'no'];

        if (!in_array($status, $statusOptions))
        {
            return redirect(route('consultationInDetails', ['invoice' => $invoice->id]))
                ->with('error', 'Status to update is invalid, try again');
        }

        $invoice->paid = $status;
        $invoice->save();
        return redirect(route('consultationInDetails', ['invoice' => $invoice->id]))
            ->with('success', 'Changed successfully');

    }


    // Prescription
    public function pendingPrescriptions()
    {
        $pendingConsultsInvoi = $this->invoicesPaidStatus('pending');
        return view('finance.prescription_invoice_list', ['consultations' => $pendingConsultsInvoi]);
    }
    public function paidPrescriptions()
    {
        $pendingConsultsInvoi = $this->invoicesPaidStatus('yes');
        return view('finance.prescription_invoice_list', ['consultations' => $pendingConsultsInvoi]);
    }
    public function unpaidPrescriptions()
    {
        $pendingConsultsInvoi = $this->invoicesPaidStatus('no');
        return view('finance.prescription_invoice_list', ['consultations' => $pendingConsultsInvoi]);
    }


    public static function invoicesPaidStatus($status)
    {
        $consulsWithPres = PharmacyController::consultationsWithPrescriptions();
        $statusedInvoice = [];

        foreach($consulsWithPres as $consulWithPres)
        {
            $prescriptions = $consulWithPres->prescriptions;
            $add = false;

            foreach($prescriptions as $prescription)
            {
                $hasInvoice = PharmacyController::prescriptionHasInvoice($prescription);
                if ($hasInvoice)
                {
                    if ($prescription->prescription_invoice->paid == $status)
                    {
                        $add = true;
                    break;
                    }
                }
            }
            if ($add)
            {
                array_push($statusedInvoice, $consulWithPres);
                $add = false;
            }
        }
        return $statusedInvoice;
    }

    public function prescriptionDetails(Request $request, Consultation $consultation)
    {
        if (!PharmacyController::consultationHasPrescription($consultation))
        {
            return redirect()->back()->with('error', 'consultation has no prescriptions.');
        }

        return view('finance.prescription_details', ['consultation' => $consultation]);
    }

    public function updateInvoiceDetails(Request $request, PrescriptionInvoice $invoice)
    {
        $options = ['yes', 'no', 'pending'];
        $paid = $request->validate(['pay' => 'required|string'])['pay'];
        if(!in_array($paid, $options))
            return redirect()->back()->with('error', 'unable to update, try again');

        $invoice->paid = $paid;
        $invoice->save();
        return redirect()->back()->with('message', 'Updated invoice payment details.');
    }
}
