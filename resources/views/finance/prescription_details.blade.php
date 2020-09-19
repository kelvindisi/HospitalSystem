@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="card-title text-center">
                <h4 class="bold">Prescription Details</h4>
            </div>
            <div class="col-12">
                @include('doctor.patient_details')
                <hr>
            </div>
            <div class="col-12">
                <p class="h3 bold">Prescriptions</p>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable">
                        <thead>
                            <tr>
                                <th>Drug</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultation->prescriptions as $prescription)
                            @if($prescription->prescription_invoice)
                            <tr>
                                <?php 
                                    $invoice =  $prescription->prescription_invoice;
                                    $paid = $invoice->paid 
                                ?>
                                <td> {{ $prescription->drug->name }} </td>
                                <td> {{ $prescription->prescription_invoice->amount }} </td>
                                <td> {{ ucfirst(trans($paid)) }} </td>
                                <td>
                                    <form action="{{ route('update_prescription', [$invoice->id]) }}" method="post" class="form-inline">
                                        @csrf
                                        <div class="form-group">
                                            <select name="pay" id="pay" class="form-control">
                                                <option value="pending" @if($paid=="pending"){{_('selected')}}@endif>Pending</option>
                                                <option value="no" @if($paid=="no"){{_('selected')}}@endif>No</option>
                                                <option value="yes" @if($paid=="yes"){{_('selected')}}@endif>Yes</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button class="ml-3 btn btn-primary">Confirm</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection