@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="card-title">
                <p class="bold h3">Drug Details</p>
                <hr>
                <div class="row">
                    <a href="{{ route('drugs.edit', ['drugs' => $drug->id] }}" 
                            class="btn btn-primary col-sm-12 col-md-6 btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div class="row">

                    <div class="col-6-12 col-md-2">
                        <strong>Name:</strong>
                    </div>
                    <div class="col-6-12 col-md-4"> {{ $drug->name }}</div>
                    
                    <div class="col-6-12 col-md-2">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-6-12 col-md-4"> {{ $drug->description }}</div>
                    
                    <div class="col-6-12 col-md-2">
                        <strong>Price:</strong>
                    </div>
                    <div class="col-6-12 col-md-4"> {{ $drug->amount }}</div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection