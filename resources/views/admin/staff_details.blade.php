@extends('layouts.staff')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header bg-success h2 bolder" style="color: white;">
                <div class="card-title">User Details</div>
            </div>
            <div class="card-body">
                @include('layouts.messages')
                <div class="row">
                    <!-- Name -->
                    <div class="col-sm-4 col-md-2">
                        <strong>Name: </strong>
                    </div>
                    <div class="col-sm-8 col-md-4">{{ $staff->name }}</div>
                    <!-- Email -->
                    <div class="col-sm-4 col-md-2">
                        <strong>Email: </strong>
                    </div>
                    <div class="col-sm-8 col-md-4">{{ Str::lower($staff->email) }}</div>
                    <!-- ID Number -->
                    <div class="col-sm-4 col-md-2">
                        <strong>ID Number: </strong>
                    </div>
                    <div class="col-sm-8 col-md-4">{{ $staff->id_number }}</div>
                    <!-- Gender -->
                    <div class="col-sm-4 col-md-2">
                        <strong>Gender: </strong>
                    </div>
                    <div class="col-sm-8 col-md-4">{{ ucfirst(trans($staff->gender)) }}</div>

                    <div class="col-12">
                        <hr>
                        <div class="h3">User Role</div>
                        <hr>
                    </div>

                    <div class="col offset-1">
                        @include('admin.roles_details')
                    </div>

                    
                </div> <!-- End of row -->

            </div> <!-- End of Card Body -->
            <div class="card-footer">
                
            </div> <!--Card footer -->
        </div>
    </div>
@endsection