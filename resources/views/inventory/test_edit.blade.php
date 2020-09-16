@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <form method="POST" action="{{ route('tests.update', ['test' => $test->id]) }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                        name="name" value="@if(old('name')){{ old('name')}}@else{{$test->name}}@endif" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="charge" class="col-md-4 col-form-label text-md-right">{{ __('Charge') }}</label>

                    <div class="col-md-6">
                        <input id="charge" type="numeric" class="form-control @error('charge') is-invalid @enderror" 
                        name="charge" value="@if(old('charge')){{ old('charge')}}@else{{$test->charge}}@endif" autocomplete="false">

                        @error('charge')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                    <div class="col-md-6">
                        <textarea name="description" class="form-control @error('dob') is-invalid @enderror"
                         id="" cols="30" rows="10" required autocomplete="description"
                         >@if(old('description')){{old('description')}}@else{{$test->description}}@endif</textarea>

                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-dark">
                            {{ __('Update test') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection