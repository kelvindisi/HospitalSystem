@extends('layouts.staff')


@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="card-title">
                <p class="bold h4">Test Requested</p>
                <hr>
            </div>
            <div class="col-12">
                <p class="bold h5">Patient</p>
                <hr>
                @include('doctor.patient_details');
                <hr>
            </div>
            <div class="col-12">
                <p class="bold h5">Test Requested</p>
                <hr>
                @include('lab.pending_test_requested');
                <hr>
            </div>

        </div>
    </div>
</div>
@endsection