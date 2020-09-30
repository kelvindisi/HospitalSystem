@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Consultation Invoices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $consultationInv }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-danger fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pharmacy Invoices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $prescriptionInv }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-primary fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Test Invoices</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $testInv }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-success fas fa-file-invoice-dollar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="card shadow">
        <div class="card-body">
            <div class="text-right">
                <p class="h3 bold">Welcome</p>
                <p class="bolder">You have been logged in as accountant</p>
            </div>
            <hr>
            <div class="container">
                <div class="card-deck menu">

                    <div class="card bg-success shadow">
                        <div class="card-body">
                            <h1 class="text-gray text-center card-title text-white bolder">Consultation Invoice</h1>
                            <hr>
                            <div class="col-12 text-center">
                                <a href="{{ route('consultationInvoices') }}">
                                    <i class="fas fa-file-invoice fa-3x text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body bg-primary shadow">
                            <h1 class="text-gray text-center card-title text-white bolder">Test Invoice</h1>
                            <hr>
                            <div class="col-12 text-center">
                                <a href="{{ route('tests.pending') }}">
                                    <i class="fas fa-file-invoice fa-3x text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-danger shadow">
                        <div class="card-body">
                            <h1 class="text-gray text-center card-title text-white bolder">Prescription Invoice</h1>
                            <hr>
                            <div class="col-12 text-center">
                                <a href="{{ route('pending_prescriptions') }}">
                                    <i class="fas fa-file-invoice fa-3x text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
