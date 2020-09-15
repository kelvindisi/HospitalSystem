@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="table responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->consultation->patient->name }}</td>
                            <td>{{ $invoice->amount }}</td>
                            <td>{{ $invoice->paid }}</td>
                            <td>
                                <a href="{{ route('consultationInDetails', ['invoice' => $invoice->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit">Update</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection