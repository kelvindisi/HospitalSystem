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
                            <th>Consultation Fee (Ksh)</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modes as $mode)
                        <tr>
                            <td> {{ $mode->name }} </td>
                            <td> {{ $mode->consultation_fee }} </td>
                            <td>
                                <a href="{{ route('payment_mode_edit', ['mode' => $mode->id]) }}" class="btn btn-sm-btn-primary">
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