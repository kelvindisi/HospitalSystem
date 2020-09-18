@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="card-title">
                <p class="bolder h4 text-center">Prescription</p>
                <hr>
            </div>
            <div class="col-12">
                <p class="bold h5">Patient</p>
                <hr>
                @include('doctor.patient_details')
                <hr>
            </div>

            <div class="col-12">
                <p class="bold h5">Prescriptions</p>
                <hr>
                @include('pharmacy.prescriptions')
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection