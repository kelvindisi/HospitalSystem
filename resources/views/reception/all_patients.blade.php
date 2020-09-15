@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')

            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>ID Number</th>
                            <th>Edit</th>
                            <th>Consult</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->id_number }}</td>
                            <td>
                                <a href="{{ route('edit_patient', ['patient' => $patient->id])}}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('patient_details', ['patient' => $patient->id])}}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-user-plus"></i>
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