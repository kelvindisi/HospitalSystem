<?php

namespace App\Http\Controllers;

use App\Consultation;
use Illuminate\Http\Request;
use App\RequestedTest;
use App\TestInvoice;

class LabController extends Controller
{
    public function index()
    {
        return view('lab.dashboard');
    }
    public function pending()
    {
        $consultations = [];
        $consultations_ids = [];
        $pending_tests = RequestedTest::where('doable', 'pending')->oldest()->get();
        foreach($pending_tests as $rqTest)
        {
            $consultation = $rqTest->consultation;
            if (!in_array($consultation->id, $consultations_ids))
            {
                array_push($consultations, $consultation);
                array_push($consultations_ids, $consultation->id);
            }
        }

        return view('lab.pending_tests', ['consultations' => $consultations]);
    }

    public function details(Request $request, Consultation $consultation)
    {
        return view('lab.test_pending_details', ['consultation' => $consultation]);
    }

    public function updateDoability(Request $request, RequestedTest $rqTest)
    {
        $doable = $request->validate(['doable' => 'required|string'])['doable'];

        if(!in_array($doable, ['yes', 'no', 'pending']))
            return redirect()->back()->with('error', 'Please choose the right options');

        if ($doable == 'yes')
        {
            if ($rqTest->doable == 'yes')
                return redirect()->back()->with('message', 'Test is already added in payment list.');
            if ($this->createTestInvoice($rqTest)){
                $rqTest->doable = 'yes';
                $rqTest->save();
                return redirect()->back()->with('success', 'Added to payment list proceed to finance.');
            }else
                return redirect()->back()->with('error', 'Test maybe already on payment list.');
        }

        //delete invoice
        if ($rqTest->doable == 'yes' )
        {
            if ($this->deleteTestInvoice($rqTest))
            {   
                $rqTest->doable = $doable;
                $rqTest->save();

                return redirect()->back()->with('success', 'Removed test request from payment list.');
            }else {
                return redirect()->back()->with('error', 'Failed to remove test payment list, payment maybe already processed');
            }
        }

        $rqTest->doable = $doable;
        $rqTest->save();
        return redirect()->back()->with('message', 'Updated test request details');
        
    }

    public function processed()
    {
        $consultations = [];
        $consultationIds = [];
        $invoices = TestInvoice::where('paid', 'yes')->get();
        foreach($invoices as $invoice)
        {
            $rqTest = $invoice->requested_test;
            $consultation = $invoice->requested_test->consultation;

            if (!in_array($consultation->id, $consultationIds))
            {
                if (!in_array($consultation->id, $consultationIds))
                {
                    if (!$rqTest->test_result)
                    {
                        array_push($consultations, $consultation);
                    }
                }
                array_push($consultationIds, $consultation->id);
            }
        }

        return view('lab.processed_for_test', ['consultations' => $consultation]);
    }

    public static function deleteTestInvoice($rqTest)
    {
        if (!$rqTest->test_invoice)
            return false;
        
        $invoice = $rqTest->test_invoice;
        $invoice->delete();
        return true;
    }

    public static function createTestInvoice($rqTest)
    {
        if (!$rqTest->test_invoice)
        {
            TestInvoice::create([
                'requested_test_id' => $rqTest->id,
                'amount' => $rqTest->test->charge
            ]);
            return true;
        }else{
            return false;
        }
    }

}
