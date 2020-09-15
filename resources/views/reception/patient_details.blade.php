@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-print-none">
                @include('layouts.messages')
                @error('payment_mode')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-2 text-primary text-right">
                    <strong>Name:</strong>
                </div>
                <div class="col-xs-12 col-md-4 bold">
                    {{ $patient->name }}
                </div>
                
                <div class="col-xs-12 col-md-2 text-primary text-right">
                    <strong>Date of Birth:</strong>
                </div>
                <div class="col-xs-12 col-md-4 bold">
                    {{ $patient->dob }}
                </div>

                <div class="col-xs-12 col-md-2 text-primary text-right">
                    <strong>Phone:</strong>
                </div>
                <div class="col-xs-12 col-md-4 bold">
                    {{ $patient->phone }}
                </div>

                <div class="col-xs-12 col-md-2 text-primary text-right">
                    <strong>Location:</strong>
                </div>
                <div class="col-xs-12 col-md-4 bold">
                    {{ $patient->location }}
                </div>

                <div class="col-xs-12 col-md-2 text-primary text-right">
                    <strong>ID No:</strong>
                </div>
                <div class="col-xs-12 col-md-4 bold">
                    {{ $patient->id_number }}
                </div>
            </div>
            <!-- Payment Modal -->
            <hr>
            <div class="row">
                <div class="offset-xl-1"></div>
                <a href="{{route('patient_edit', ['patient' => $patient->id])}}" 
                    class="btn col-xl-4 col-md-5 mb-2 btn-sm btn-primary">
                    <i class="fas fa-edit"></i>
                    <span>Edit</span>
                </a> 
                <div class="offset-md-2"></div>  
                <button class="btn col-xl-4 col-md-5 mb-2 btn-sm btn-success" data-toggle="modal" data-target="#paymentModeModal">
                    <i class="fas fa-user-plus"></i>
                    <span>Consultation</span>
                </button>
            </div>
            <div class="d-print-none">
                <hr>
                <p class="bolder h3 text-primary">Consultation History</p>
                <hr><hr>
            </div>
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patient->consultations as $consultation)
                        <tr>
                            <td>{{ $consultation->created_at->format('d-m-Y') }}</td>
                            <td>{{ $consultation->created_at->format('H:m:s') }}</td>
                            <td>{{ ucfirst(trans($consultation->status)) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('reception.modal_payment_mode')
        </div> <!-- End of Card Body -->
    </div>
</div>
@endsection