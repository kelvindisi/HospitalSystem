@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @include('layouts.messages')
                    <div class="card-title text-center">
                        <h2>Update Payment Mode</h2>
                        <hr>
                    </div>
                    <form method="POST" action="{{ route('payment_mode_update', ['mode' => $mode->id]) }}">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                 name="name" value="@if(old('name')){{old('name') }}@else{{$mode->name}}@endif " required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="consultation_fee" class="col-md-4 col-form-label text-md-right">{{ __('Consultation Fee') }}</label>

                            <div class="col-md-6">
                                <input id="consultation_fee" type="numeric" class="form-control @error('consultation_fee') is-invalid @enderror" name="consultation_fee"
                                 value="@if(old('consultation_fee')){{old('consultation_fee') }}@else{{$mode->consultation_fee}}@endif" required autocomplete="consultation_fee">

                                @error('consultation_fee')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Update Payment Mode') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
