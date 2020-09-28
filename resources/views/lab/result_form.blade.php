@extends('layouts.staff')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <p class="bolder h5">Fill Results</p>
                </div>
                @include('layouts.messages')
                <hr>
                <div class="col-12">
                    <p class="bold">Patient Details</p>
                    <hr>
                    @include('doctor.patient_details')
                </div>
                <hr>
                <div class="col-12">
                    <p class="bold">Test</p>
                    <hr>
                    @include('lab.test_details')
                </div>
                <hr>
                <div class="col-12">
                    <p class="bold">Results</p>
                    @include('lab.form_results')
                </div>
            </div>
        </div>
    </div>
@endsection
