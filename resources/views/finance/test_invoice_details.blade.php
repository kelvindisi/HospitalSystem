@extends('layouts.staff')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <p class="h4">Test Invoice Details</p>
                </div>
                @include('layouts.messages')
                <div class="col-12">
                    <hr>
                    <p class="h5">Patient Details</p>
                    <hr>
                    @include('doctor.patient_details')
                    <hr>
                </div>
                <div class="col-12">
                    <hr>
                    <p class="h5">Test Invoices</p>
                    <hr>
                    @include('finance.test_inv_by_consul')
                    <hr>
                </div>

            </div>
        </div>
    </div>
@endsection
