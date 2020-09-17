@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="row">
                <div class="col-12">
                    <p class="bold h5">Patient</p>
                    <hr>
                    @include('doctor.patient_details')
                    <hr>
                </div>
                <div class="col-12">
                    <p class="bold h5">Drug</p>
                    <hr>
                    @include('doctor.drug_details')
                    <hr>
                </div>
                <div class="col-12">
                    <p class="bold h5">Prescription</p>
                    <hr>
                    @include('doctor.prescription_form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection