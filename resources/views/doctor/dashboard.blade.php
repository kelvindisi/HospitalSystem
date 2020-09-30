@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pending Consultations</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-danger fas fa-lock fa-2x text-gray-300"></i>
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
                            <h1 class="text-gray text-center card-title text-white bolder">Pending Consultations</h1>
                            <hr>
                            <div class="col-12 text-center">
                                <a href="{{ route('doctor.pending') }}">
                                    <i class="fas fa-file-invoice fa-3x text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body bg-primary shadow">
                            <h1 class="text-gray text-center card-title text-white bolder">Pending Lab Results</h1>
                            <hr>
                            <div class="col-12 text-center">
                                <a href="{{ route('doctor.pending_results') }}">
                                    <i class="fas fa-file-invoice fa-3x text-white"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-danger shadow">
                        <div class="card-body">
                            <h1 class="text-gray text-center card-title text-white bolder">Ready Lab Results</h1>
                            <hr>
                            <div class="col-12 text-center">
                                <a href="{{ route('doctor.pending_results') }}">
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
