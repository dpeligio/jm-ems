@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Users</h1>
            </div>
            <div class="col-md-6 text-right">
                {{-- @can('users.create')
                    <button class="btn btn-default text-primary" data-href="{{ route('users.create') }}" type="button" data-toggle="modal-ajax" data-target="#createUser"><i class="fa fa-plus"></i> Add</button>
                @endcan --}}
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                @if($user->is_verified == 0)
                    @isset($user->student->id)
                    <label>School ID::</label>
                    <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#viewSchoolIDImage">View</button>
                    @endif
                    <br>
                @endif
                <label class="mb-0">Status:</label>
                @if($user->is_verified == 1)
                <span class="badge badge-success">Verified</span>
                @else
                <span class="badge badge-warning">Under Validation</span>
                @endif
                <br>
                <label class="mb-0">Role:</label>
                {{ $user->role->role->name }}
                <br>
                <label class="mb-0">Username:</label>
                {{ $user->username }}
                <br>
                <label class="mb-0">Email:</label>
                {{ $user->email }}
            </div>
            <div class="col-md-6">
                @isset($user->student->id)
                    <label class="mb-0">Student ID:</label>
                    <a href="{{ route('students.show', $user->student->student_id) }}">{{ $user_info->student_id }}</a>
                    <br>
                @else
                    <label class="mb-0">Faculty ID:</label>
                    <a href="{{ route('faculties.show', $user_info->faculty_id) }}">{{ $user_info->faculty_id }}</a>
                    <br>
                @endisset
                <label class="mb-0">First Name:</label>
                {{ $user_info->first_name }}
                <br>
                <label class="mb-0">Middle Name:</label>
                {{ $user_info->middle_name }}
                <br>
                <label class="mb-0">Last Name:</label>
                {{ $user_info->last_name }}
                <br>
                <label class="mb-0">Suffix:</label>
                {{ $user_info->suffix }}
                <br>
                <label class="mb-0">Gender:</label>
                {{ $user_info->gender }}
                <br>
                <label class="mb-0">Contact #:</label>
                {{ $user_info->contact_number }}
                <br>
                <label class="mb-0">Address #:</label>
                {{ $user_info->address }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
    