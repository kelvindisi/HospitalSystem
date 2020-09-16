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
                            <th>Patient Name</th>
                            <th>Gender</th>
                            <th>Phone No</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                        <tr>
                            <td> {{ $consultation->patient->name }} </td>
                            <td> {{ ucfirst(trans($consultation->patient->gender)) }} </td>
                            <td> {{ $consultation->patient->phone }} </td>
                            <td>
                                <a href="{{ route('doctor.pending_open', ['consultation' =>  $consultation->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-folder-open"></i>
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