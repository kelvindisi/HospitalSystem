<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Consultation;
use App\PaymentMode;
use Carbon\Carbon;
use Faker\Provider\ar_SA\Payment;

class ReceptionistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Consultation::where(['status' => 'pending'])->count();
        return view('reception.dashboard', ['pending' => $count]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reception.add_patient');
    }

    /**
     * Return List of all patients
     */
    public function patients()
    {
        $context = ['patients' => Patient::all()];
        return view('reception.all_patients')->with($context);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'location' => ['required', 'string']
        ]);

        if ($request->post('id_number'))
        {
            $idDetails = $request->validate(['id_number' => ['numeric', 'unique:patients']]);
            $data['id_number'] = $idDetails['id_number'];
        }

        $patient = Patient::create($data);
        return redirect(route('patient_details', ['patient' => $patient->id]))
                ->with('success', 'patient account created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        return view('reception.patient_details', [
            'patient' => $patient,
            'modes' => PaymentMode::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        return view('reception.edit_patient')->with(['patient' => $patient]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'location' => ['required', 'string']
        ]);

        $patientId = $request->validate(['patient_id' => ['required', 'numeric']])['patient_id'];

        if ($request->post('id_number'))
        {
            $idDetails = $request->validate(['id_number' => 'numeric']);
            $data['id_number'] = $idDetails['id_number'];
            $searchPatient = Patient::where(['id_number' => $data['id_number']])->first();
            if ($searchPatient)
            {
                if ($searchPatient->id_number != $patient->id_number)
                {
                    return redirect(route('patient_details', ['patient' => $patient->id]))
                            ->with('error', "A patient with ID No: {$data['id_number']} already exists.");
                }
            }
        }



        if ($patientId != $patient->id)
        {
            return redirect(route('patient_details', ['patient' => $patient->id]))
                    ->with('error', "Error occured while to update details, try again.");
        }
        $patient->update($data);
        return redirect(route('patient_details', ['patient' => $patient->id]))
                ->with('success', "Successfully updated.");

    }
    public function addConsult(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'payment_mode' => 'required|numeric'
        ]);
        if (!PaymentMode::find($data['payment_mode']))
        {
            return redirect(route('patient_details', ['patient' => $patient->id]))
                ->with('error', "Mode of payment selected is not valid");
        }

        $consultations  = Consultation::where(['patient_id'=> $patient->id, 'status' => 'pending'])->latest()->get();
        $todaysDate = Carbon::now();

        foreach($consultations as $consultation)
        {
            if ($todaysDate->isSameDay($consultation->created_at))
            {
                return redirect(route('pending_consultations'))
                    ->with('warning', 'Already have a consultation scheduled for today.');
            }
        }

        $dt['payment_mode_id'] = $data['payment_mode'];
        $dt['patient_id'] = $patient->id;

        Consultation::create($dt);

        return redirect(route('pending_consultations'))
            ->with('success', 'Patient added to consultation list successfully');

    }
    public function pendingConsultations()
    {
        $pendingConsultation = Consultation::where(['status' => 'pending'])->latest()->get();
        $context = ['consultations' => $pendingConsultation];

        return view('reception.pending_consultation')->with($context);
    }
    public function removeConsultation(Request $request, Consultation $consultation)
    {
        // To remove only the unpaid consultations
        if ($consultation->consultation_invoice->paid == 'pending')
        {
            $patient_name = $consultation->patient->name;
            $consultation->delete();
            $message['message'] = "Removed {$patient_name} from patient consultation list.";
            $message['type'] = 'success';
        } else {
            $message['type'] = 'error';
            $message['message'] = "Failed, the patient has paid consultation fee or invoice has been processed already";
        }

        return redirect(route('pending_consultations'))->with($message['type'], $message['message']);
    }
}
