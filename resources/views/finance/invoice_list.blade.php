@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @extends('layouts.messages')

            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <td>Phone</td>
                            <th>ID Number</th>
                            <th>Amount</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->name }}</td>
                            <td>{{ $invoice->Phone }}</td>
                            <td>{{ $invoice->id_number }}</td>
                            <td>
                                <a href="" class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
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