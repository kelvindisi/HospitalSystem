@extends('layouts.staff')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <p class="h5 bold">Patient Tests</p>
                    @include('layouts.messages')
                    <hr>
                    <div class="col-12">
                        <p class="bold">Patient Details</p>
                        @include('doctor.patient_details')
                        <hr>
                    </div>
                    <div class="col-12">
                        <p class="bold">Tests</p>
                        @include('lab.test_lists')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
