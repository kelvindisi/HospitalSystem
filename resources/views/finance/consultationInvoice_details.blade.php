@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="card-title bolder h3 text-center">Consultation Invoice</div>
            <hr>
            
            <div class="col-12">
                <p class="bold h5">Patient</p><hr>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-2">
                    <strong>Name</strong>
                </div>
                <div class="col-sm-6 col-md-4">
                    <span> {{ $invoice->consultation->patient->name }} </span>
                </div>
                <div class="col-sm-6 col-md-2">
                    <strong>Gender</strong>
                </div>
                <div class="col-sm-6 col-md-4">
                    <span> {{ ucfirst(trans($invoice->consultation->patient->gender)) }} </span>
                </div>
                <div class="col-sm-6 col-md-2">
                    <strong>Phone</strong>
                </div>
                <div class="col-sm-6 col-md-4">
                    <span> {{ $invoice->consultation->patient->phone }} </span>
                </div>
                <div class="col-sm-6 col-md-2">
                    <strong>ID No.</strong>
                </div>
                <div class="col-sm-6 col-md-4">
                    <span> {{ ucfirst(trans($invoice->consultation->patient->id_number)) }} </span>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <p class="bold h5">Invoice</p><hr>
                <hr>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-2">
                    <strong>Status</strong>
                </div>
                <div class="col-sm-6 col-md-4">
                    <?php 
                        $paid = $invoice->paid;
                        if ($paid == 'no')
                            $print_message = 'Not Paid'; 
                        elseif ($paid == 'yes')
                            $print_message = 'Paid'; 
                        elseif ($paid == 'pending')
                            $print_message = 'Pending'; 
                        else
                            $print_message = $invoice->paid;
                        
                    ?>
                    <span> {{ $print_message }} </span>
                </div>
                <div class="col-sm-6 col-md-2">
                    <strong>Amount</strong>
                </div>
                <div class="col-sm-6 col-md-4">
                    <span> {{ $invoice->amount }} </span>
                </div>
            </div>
            <hr>
            <form action="{{ route('conInUpdate', ['invoice' => $invoice->id]) }}" method="post" class="form-inline">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="status"><strong>Status:</strong></label>
                    <select name="status" class="form-control" style="max-width: 200px;" id="status">
                        <option value="pending">Pending</option>
                        <option value="no">Not Paid</option>
                        <option value="yes">Paid</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="ml-2 btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection