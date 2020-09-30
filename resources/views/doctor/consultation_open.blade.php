@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="col-12">
                <p class="bold h5">Patient</p>
            </div>
            <hr>
            <div class="col-12">
                @include('doctor.patient_details')
                <hr>
                <hr>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    @include('doctor.diagnosis_form')
                </div>
                <div class="col-md-4 col-sm-12 flex-row">
                   <div class="col-12">
                        <button class="btn btn-block btn-lg btn-warning" data-toggle="modal" data-target="#patientResults">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-vial"></i>
                                </div>
                                <div class="col-sm-9 text-left">
                                    <span>Lab Result</span>
                                </div>
                            </div>
                        </button>
                   </div>
                   <div class="col-12 mt-3">
                        <button class="btn btn-block btn-lg btn-outline-success" data-toggle="modal" data-target="#patientHistory">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <div class="col-sm-9 text-left">
                                    <span>Patient History</span>
                                </div>
                            </div>
                        </button>
                   </div>
                   <div class="col-12 mt-3">
                        <a href="{{ route ('doctor.prescribe', ['consultation' => $consultation->id]) }}" class="btn btn-block btn-lg btn-outline-dark">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-user-tag"></i>
                                </div>
                                <div class="col-sm-9 text-left">
                                    <span>Prescribe Drugs</span>
                                </div>
                            </div>
                        </a>
                   </div>
                   <div class="col-12 mt-3">
                        <a href="{{ route('doctor.testRequest',['consultation'=>$consultation->id]) }}" class="btn btn-block btn-lg btn-outline-danger">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-vials"></i>
                                </div>
                                <div class="col-sm-9 text-left">
                                    <span>Request Lab Test</span>
                                </div>
                            </div>
                        </a>
                   </div>
                   <div class="col-12 mt-3">
                        <a href="{{ route('doctor.complete', ['consultation' => $consultation->id]) }}" class="btn btn-block btn-lg btn-primary">
                            <div class="row">
                                <div class="col-sm-3">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="col-sm-9 text-left">
                                    <span>Complete Treatment</span>
                                </div>
                            </div>
                        </a>
                   </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('doctor.patient_history')
@include('doctor.patient_lab_results')
@endsection
