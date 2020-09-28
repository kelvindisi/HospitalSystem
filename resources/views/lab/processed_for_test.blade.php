@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient Name</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($consultations as $consultation)
                        <tr>
                            <td>{{ $consultation->created_at }}</td>
                            <td>{{ $consultation->patient->name }}</td>
                            <td>
                                <a href="{{ route('lab.processTest', $consultation->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-open"></i>
                                    <small>Open</small>
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
