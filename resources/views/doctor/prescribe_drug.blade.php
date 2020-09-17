@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="col-12">
                <p class="bold h5">Patient</p>
            </div>
            <hr>
            <div class="col-12">
                @include('doctor.patient_details')
                <hr>
                <hr>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 p-3" style="background-color:#ececf0 !important;
;">
                    <p class="bold">Drug List</p>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Add</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drugs as $drug)
                                <tr>
                                    <td> {{ $drug->name }} </td>
                                    <td>
                                        <a 
                                            href="{{ route('doctor.issue', ['consultation'=>$consultation->id, 'drug_id'=>$drug->id]) }}"
                                             class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <p class="bold">Prescribed Drug</p>
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                @foreach($consultation->prescriptions as $prescription)
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td> {{ $prescription->drug->name }} </td>
                                    <td> {{ $prescription->quantity }} </td>
                                    <td>
                                        <a href="{{ route('doctor.removedrug', ['consultation'=>$consultation->id, 'drug_id'=>$prescription->drug_id]) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-minus"></i>
                                        </a>
                                    </td>
                                    <?php $counter += 1; ?>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection