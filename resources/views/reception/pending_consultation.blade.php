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
                            <th>Gender</th>
                            <th>Phone</th>
                            <th>Paid</th>
                            <th>Date</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                        <tr>
                            <td>{{ $consultation->patient->name }}</td>
                            <td>{{ $consultation->patient->gender }}</td>
                            <td>{{ $consultation->patient->phone }}</td>
                            <td>{{ $consultation->status }}</td>
                            <td>{{ $consultation->created_at }}</td>
                            <td>
                                <a href="{{ route('delete_consultation', ['consultation' => $consultation->id]) }}" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i>
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