<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Consultation;
use App\RequestedTest;
use App\Test;
use App\Drug;
use App\Prescription;

class DoctorController extends Controller
{
    public function index()
    {
        $pendingCount = Consultation::where('status', 'pending')->count();
        return view('doctor.dashboard', ['pendingCount' => $pendingCount]);
    }

    public function pendingList()
    {
        $list = Consultation::where(['status' => 'pending'])->oldest()->get();
        $consultations = [];
        foreach($list as $consultation)
        {
            if ($consultation->consultation_invoice->paid == 'yes')
            {
                if ($consultation->requested_tests->count() == 0)
                    array_push($consultations, $consultation);
            }
        }

        return view('doctor.consultations', ['consultations' => $consultations]);
    }

    public function pendingProcessingTests()
    {
        $list = Consultation::where(['status' => 'pending'])->oldest()->get();
        $consultations = [];
        foreach($list as $consultation)
        {
            if ($consultation->consultation_invoice->paid == 'yes')
            {
                if ($consultation->requested_tests->count() > 0)
                {
                    $tests =  $consultation->requested_tests;

                    foreach($tests as $test)
                    {
                        if ($test->doable == 'pending')
                            array_push($consultations, $consultation);
                    }
                }

            }
        }

        return view('doctor.consultations', ['consultations' => $consultations]);
    }

    public function pendingLabList()
    {
        $list = Consultation::where(['status' => 'pending'])->oldest()->get();
        $consultations = [];
        foreach($list as $consultation)
        {
            if ($consultation->consultation_invoice->paid == 'yes')
            {
                if ($consultation->requested_tests->count() > 0) {
                    if ($this->atleastOnePaidTest($consultation)
                        && !$this->allWithResults($consultation)) {
                        array_push($consultations, $consultation);
                    }
                }
            }
        }

        return view('doctor.consultations', ['consultations' => $consultations]);
    }
    public function readyLabList()
    {
        $list = Consultation::where(['status' => 'pending'])->oldest()->get();
        $consultations = [];
        foreach($list as $consultation)
        {
            if ($consultation->consultation_invoice->paid == 'yes') // Consultation fee is paid
            {
                if ($consultation->requested_tests->count() > 0) {
                    if ($this->atleastOnePaidTest($consultation)
                        && $this->allWithResults($consultation)) {
                        array_push($consultations, $consultation);
                    }
                }
            }
        }

        return view('doctor.consultations', ['consultations' => $consultations]);
    }

    private function allWithResults($consultation)
    {
        $tests = $consultation->requested_tests;

        foreach ($tests as $test)
        {
            if ($this->hasPaidInvoice($test))
            {
                if (!$test->test_result)
                    return false;
            }
        }

        return true;
    }
    /**
     * Check if has one paid test
     * @param $consultation
     * @return bool
     */
    private function atleastOnePaidTest($consultation)
    {
        $rqTests = $consultation->requested_tests;
        $onePaid = false;

        foreach ($rqTests as $rqTest)
        {
            if ($this->hasPaidInvoice($rqTest))
                $onePaid = true;
        }

        return $onePaid;
    }

    /**
     * Check if test has Invoice and if paid
     * @param $rqTest
     * @return bool
     */
    private function hasPaidInvoice($rqTest)
    {
        if (!$rqTest->test_invoice)
            return false;
        if ($rqTest->test_invoice->paid == 'yes')
            return true;
    }

    public function pendingDetails(Request $request, Consultation $consultation)
    {
        return view('doctor.consultation_open', ['consultation' => $consultation]);
    }
    public function updateDiagnosis(Request $request, Consultation $consultation)
    {
        $data = $request->validate([
            'diagnosis' => 'string'
        ]);
        $consultation->diagnosis = $data['diagnosis'];
        $consultation->save();

        return redirect()->back()->with('success', 'Consultation diagnosis updated.');
    }
    public function completeTreatement(Request $request, Consultation $consultation)
    {
        $tests = $consultation->requested_tests;
        foreach($tests as $test)
        {
            if ((!$test->complete) && $test->paid)
            {
                return redirect()->back()->with('error', 'Patient has pending result for the current treatment session');
            }
        }

        $consultation->status = 'seen';
        $consultation->save();

        return redirect(route('doctor.pending'))->with('message', 'Consultation completed!');
    }
    public function testRequest(Request $request, Consultation $consultation)
    {

        $consTestsIds = $consultation->requested_tests->pluck('test_id')->all();
        $tests = DB::table('tests')->whereNotIn('id', $consTestsIds)->get();
        $context = [
            'consultation' => $consultation,
            'tests' => $tests
        ];

        return view('doctor.request_test')->with($context);
    }
    public function prescribeDrug(Request $request, Consultation $consultation)
    {
        //$presDrugsIds = $consultation->prescriptions->pluck('drug_id')->all();
        //$drugs = DB::table('drugs')->whereNotIn('id', $presDrugsIds)->get();
        $context = [
            'drugs' => Drug::all(),
            'consultation' => $consultation
        ];
        return view('doctor.prescribe_drug')->with($context);
    }
    public function prescribeIssue(Request $request, Consultation $consultation, $drug_id)
    {
        $drug = Drug::find($drug_id);
        if (!$drug)
            return redirect()->back()->with('error', 'Drug submitted to issue is not in drug list.');
        $context = [
            'drug' => $drug,
            'consultation' => $consultation,
            'prescribed' => 1
        ];
        $presIds = $consultation->prescriptions->pluck('drug_id')->all();
        if (in_array($drug->id, $presIds))
        {
            $presCount = Prescription::where(['consultation_id' => $consultation->id, 'drug_id' => $drug->id])
                        ->first();
            if ($presCount)
                $context['prescribed'] = $presCount->quantity;
        }
        return view('doctor.send_prescription')->with($context);
    }
    public function addPrescription(Request $request, Consultation $consultation)
    {
        $data = $request->validate([
            'drug' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);
        if ($data['quantity'] < 1)
        {
            return redirect()->back()->with('error', 'Minimum prescription quantity is 0');
        }
        // Check if it's valid Drug
        if (!Drug::find($data['drug']))
        {
            return redirect()->back()->with('error', 'Drug prescribed in not in drug records.');
        }
        // Check if already prescribed
        $prescribed = Prescription::where([
                'consultation_id' => $consultation->id,
                'drug_id' => $data['drug']
            ])->first();
        if ($prescribed)
        {
            // update prescription
            $prescribed->quantity = $data['quantity'];
            $prescribed->save();
            return redirect(route('doctor.prescribe', ['consultation' => $consultation->id]))
                ->with('message', 'Prescription quantity updated');
        }
        Prescription::create([
            'consultation_id' => $consultation->id,
            'drug_id'=> $data['drug'],
            'quantity' => $data['quantity']
        ]);
        return redirect(route('doctor.prescribe', ['consultation' => $consultation->id]))
            ->with('message', 'Prescription added to list');

    }
    public function removedrug(Request $request, Consultation $consultation, $drug_id)
    {
        if (!Drug::find($drug_id))
        {
            return redirect()->back()->with('error', 'Drug you want to remove is not in drug list.');
        }
        $prescriptions = $consultation->prescriptions->where('drug_id', $drug_id);
        foreach($prescriptions as $prescription)
        {
            $prescription->delete();
        }
        return redirect()->back()->with('message', 'Removed drug from prescription list.');
    }
    public function testAdd(Request $request, Consultation $consultation, $test_id)
    {
        $test = Test::find($test_id);
        if ($test)
        {
            $idList = $consultation->requested_tests->pluck('id')->all();
            if (!in_array($test->id, $idList))
            {
                $data = [
                    'consultation_id' => $consultation->id,
                    'test_id' => $test->id
                ];
                RequestedTest::create($data);
                return redirect()->back()->with('message', 'Test request submited');
            }
            return redirect()->back()->with('error', 'This test is already in the request.');
        }
        return redirect()->back()->with('error', 'Test submited to add is invalid.');
    }
    public function testRemove(Request $request, Consultation $consultation, $test_id)
    {
        $test = Test::find($test_id);
        $removed = false;
        $paid = false;

        if ($test)
        {
            $tests = $consultation->requested_tests;
            foreach($tests as $rqTest)
            {
                if ($test->id == $rqTest->test_id)
                {
                    if ($rqTest->test_invoice)
                    {
                        if ($rqTest->test_invoice->paid == 'yes')
                        {
                            $paid = true;
                        } else {
                            $rqTest->delete();
                            $removed = true;
                        }
                    }else{
                        $rqTest->delete();
                        $removed = true;
                    }
                }
            }
        }
        if ($removed) {
            $message['title'] = 'success';
            $message['message'] = 'Removed test from requested.';
        } elseif($paid) {
            $message['title'] = 'message';
            $message['message'] = 'Test is already paid for cannot be removed.';
        } else {
            $message['title'] = 'error';
            $message['message'] = 'Unable to delete the test.';
        }

        return redirect()->back()->with($message['title'], $message['message']);
    }

}
