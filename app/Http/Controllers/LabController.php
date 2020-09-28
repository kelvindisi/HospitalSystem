<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\TestResult;
use Illuminate\Http\Request;
use App\RequestedTest;
use App\TestInvoice;

class LabController extends Controller
{
    public function index()
    {
        $pendingCount = RequestedTest::where('doable', 'pending')->count();
        return view('lab.dashboard', ['pending' => $pendingCount]);
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
                $this->consulCompleteFalse($rqTest);
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
                $this->consulCompleteTrue($rqTest);

                return redirect()->back()->with('success', 'Removed test request from payment list.');
            }else {
                return redirect()->back()->with('error', 'Failed to remove test payment list, payment maybe already processed');
            }
        }

        $rqTest->doable = $doable;
        $rqTest->save();
        return redirect()->back()->with('message', 'Updated test request details');

    }

    private function consulCompleteFalse($rqTest)
    {
        $consultation = $rqTest->consultation;
        if ($consultation->complete)
        {
            $consultation->test_ready = false;
            $consultation->save();
        }
    }

    private function consulCompleteTrue($rqTest)
    {
        $consultation = $rqTest->consultation;
        $tests = $consultation->requested_tests;

        $complete_ready = true;
        $one_ready = ($tests->count() == 1) && ($tests->first()->id == $rqTest->id);

        if (!$one_ready)
        {
            foreach ($tests as $test)
            {
                if ($test->doable != 'no' || $test->doable != 'pending')
                    $complete_ready = false;
            }
        }

        if ($one_ready || $complete_ready)
        {
            $consultation->test_ready = true;
            $consultation->save();
        }

    }

    public function paidUndone()
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
                        if ($this->readyForTest($consultation))
                            array_push($consultations, $consultation);
                    }
                }
                array_push($consultationIds, $consultation->id);
            }
        }

        return view('lab.processed_for_test', ['consultations' => $consultations]);
    }


    public function processTest(Request $request, Consultation $consultation)
    {
        if (!$this->readyForTest($consultation))
        {
            return redirect()->back()->with('message', 'Sorry, seems all tests payment have not been processed.');
        }

        return view('lab.process_tests', ['consultation' => $consultation]);
    }

    public function fillResults(Request $request, RequestedTest $test)
    {
        $update = false;
        if ($test->test_result)
            $update = true;
        $method = $update? 'PATCH':'POST';
        $context = ['rqTest' => $test, 'consultation' => $test->consultation];
        return view('lab.result_form', $context);
    }

    /**
     * @param Request $request
     * @param RequestedTest $test
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveResults(Request $request, RequestedTest $test)
    {
        $data = $request->validate(['result' => 'required']);

        if ($test->test_result) {
            $test->test_result()->update($data);
            return redirect()->back()->with('message', 'Updated test results successfully.');
        }

        $test->test_result()->create($data);
        return redirect()->back()->with('message', 'Saved test results successfully.');
    }

    /**
     * @return \Illuminate\view\View
     */
    public function completeTest()
    {
        $results = TestResult::all();
        $consultations = [];
        $consultations_ids = [];

        foreach ($results as $result)
        {
            if ($this->relatedTestsComplete($result))
            {
                $consultation = $result->requested_test->consultation;
                if (!in_array($consultation->id, $consultations_ids))
                {
                    array_push($consultations, $consultation);
                    array_push($consultations_ids, $consultation->id);
                }
            }
        }

        return view('lab.processed_for_test', ['consultations'=>$consultations]);
    }

    /**
     * @param $result
     * @return bool
     */
    private function relatedTestsComplete($result)
    {
        $consultation = $result->requested_test->consultation;
        $tests = $consultation->requested_tests;

        foreach($tests as $test)
        {
            if (!$this->hasInvoice($test)) // related test is on pending state
                return false;
            else {
                if (!$this->invoiceIsProcessed($test)) // test has been processed paid or not paid
                    return false;
            }

        }
        return true;
    }


    private function hasInvoice($rqTest)
    {
        return $rqTest->test_invoice? true:false;
    }
    private function invoiceIsProcessed($rqTest)
    {
        $paid = $rqTest->test_invoice->paid;
        if ($paid == 'yes' || $paid == 'no')
            return true;
        else
            return false;
    }
    private function invoiceIsPaid($rqTest)
    {
        if ($rqTest->test_invoice->paid == 'yes')
            return true;
        else
            return false;
    }
    private function readyForTest($consultation)
    {
        $ready = false;
        $inv_processed = false;

        if (!$consultation->requested_tests)
            return false;

        foreach ($consultation->requested_tests as $rqTest)
        {
            if (!$rqTest->test_result)
            {
                if ($rqTest->test_invoice)
                {
                    $paid = $rqTest->test_invoice->paid;
                    if ($paid != 'pending')
                        $inv_processed = true;
                    else
                        $inv_processed = false;
                    if (!$rqTest->test_result)
                        $ready = true;
                }
            }
        }

        return $ready && $inv_processed;
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
