@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xm-12 col-sm-3 text-right">
                    <label for="name"><strong>Name:</strong></label>
                </div>
                <div class="col-xm-12 col-sm-3">
                    <label for="name">{{ $patient->name }}</label>
                </div>
                
                <div class="col-xm-12 col-sm-3 text-right">
                    <label for="name"><strong>Gender:</strong></label>
                </div>
                <div class="col-xm-12 col-sm-3">
                    <label for="name">{{ $patient->gender }}</label>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Charges</th>
                            <th>Paid</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $requested_test->test()->name }}</td>
                            <td>{{ $requested_test->test()->charge }}</td>
                            <td>{{ $requested_test->paid }}</td>
                            <td>
                                <a href="" class="btn btn-sm btn-success">pay</a>
                                <a href="" class="btn btn-sm btn-danger">no paid</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection