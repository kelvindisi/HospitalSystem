@extends('layouts.staff')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            @include('layouts.messages')
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $staff)
                        <tr>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>
                                @if ($staff->roles()->count() > 0)
                                    <span class="text-success">
                                    <strong>{{ ucfirst(trans($staff->roles()->first()->name))}}</span></strong>
                                @else
                                    <strong><span class="text-info">{{ __('No Role') }}</span></strong>
                                @endif

                            </td>
                            <td>{{ $staff->account_status? 'Active': 'Inactive' }}</td>
                            <td class="d-flex">
                                <a href="{{ route('edit_staff', ['user'=> $staff->id]) }}" class="btn btn-sm btn-outline-primary mr-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('staff_status', ['user' => $staff->id]) }}" method="post" class="form-inline">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    @if ($staff->account_status)
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-user-alt-slash"></i>
                                    </button>
                                    @else
                                    <button class="btn btn-sm btn-success">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                    @endif
                                </form>
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