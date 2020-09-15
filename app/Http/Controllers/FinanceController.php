<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConsultationInvoice;
use App\Consultation;

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
}
