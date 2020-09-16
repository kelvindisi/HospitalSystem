<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Consultation;
use App\RequestedTest;
use App\Test;

class DoctorController extends Controller
{
    public function index()
    {
        return view('doctor.dashboard');
    }
    public function pendingList()
    {
        $list = Consultation::where(['status' => 'pending', 'test_ready' => true])->oldest()->get();
        $consultatations = [];
        foreach($list as $consultation)
        {
            if ($consultation->consultation_invoice->paid == 'yes')
            {
                if ($consultation->requested_tests->count() == 0)
                    array_push($consultatations, $consultation);
            }
        }

        return view('doctor.consultations', ['consultations' => $consultatations]);
    }
    public function pendingLabList()
    {
        $list = Consultation::where(['status' => 'pending', 'test_ready' => true])->oldest()->get();
        $consultatations = [];
        foreach($list as $consultation)
        {
            if ($consultation->consultation_invoice->paid == 'yes')
            {
                if ($consultation->requested_tests->count() > 0)
                    array_push($consultatations, $consultation);
            }
        }

        return view('doctor.consultations', ['consultations' => $consultatations]);
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
        $consTestsIds = $consultation->requested_tests->pluck('id');
        $tests = DB::table('tests')->whereNotIn('id', $consTestsIds)->get();
        $context = [
            'consultation' => $consultation,
            'tests' => $tests
        ];

        return view('doctor.request_test')->with($context);
    }
    public function prescribeDrug(Request $request, Consultation $consultation)
    {
        $presDrugs = $consultation->prescriptions;

        return view('doctor.prescribe_drug')->with($context);
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
        if ($test)
        {
            $tests = $consultation->requested_tests;
            foreach($tests as $rqTest)
            {
                if ($test->id == $rqTest->test_id)
                {
                    $rqTest->delete();
                }
            }
            return redirect()->back()->with('message', 'Removed test from requested.');
        }
        return redirect()->back()->with('error', 'Test submited to add is invalid.');
    }

}
