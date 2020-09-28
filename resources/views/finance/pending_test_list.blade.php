@extends('layouts.staff')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Open</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultations as $consultation)
                            <tr>
                                <td>{{ $consultation->created_at }}</td>
                                <td>{{ $consultation->patient->name }}</td>
                                <td>
                                    <a href="{{ route('test.detailsInv', $consultation->id) }}" class="btn btn-primary btn-sm">
                                        <span class="fas fa-folder-open"></span>
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
