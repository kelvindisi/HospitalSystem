<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        return view('finance.dashboard');
    }
    public function pendingInvoices(Request $request)
    {
       $context =  ['invoices' => []];
       return view('finance.invoice_list'); 
    }
    public function paidInvoices(Request $request)
    {
        $context =  ['invoices' => []];
        return view('finance.invoice_list'); 
    }
    public function allInvoices(Request $request)
    {
        $context =  ['invoices' => []];
        return view('finance.invoice_list'); 
    }
}
