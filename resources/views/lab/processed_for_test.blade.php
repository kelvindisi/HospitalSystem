@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Patient Name</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $consultation->created_at }}</td>
                            <td>{{ $consultation->patient->name }}</td>
                            <td>
                                <a href="" class="btn btn-outline-primary">
                                    <i class="fas fa-open"></i>
                                    <small>Open</small>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection