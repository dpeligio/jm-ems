@extends('layouts.adminlte')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Students</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6 text-right">
                @can('students.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('students.create') }}" data-target="#createStudent"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <table id="datatable" class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                @role('System Administrator')
                                <th>ID</th>
                                @endrole
                                <th>Account Status</th>
                                <th>Student ID</th>
                                <th>Year/Section</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr @unlessrole('System Administrator') @can('students.show') data-toggle="modal-ajax" data-target="#showStudent" data-href="{{ route('students.show', $student->id) }}"  @endcan @else class="{{ $student->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @role('System Administrator')
                                <td>{{ $student->id }}</td>
                                @endrole
                                <td>
                                    @isset ($student->user)
                                    @if($student->user->user->is_verified == 1)
                                        <span class="badge badge-success">Verified</span>
                                    @else
                                        <span class="badge badge-warning">Under Validation</span>
                                    @endif
                                    @else
                                        <span class="text-danger">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $student->student_id }}</td>
                                <td>
                                    {{ $student->section->section->year_level ?? "" }}
                                    {{ $student->section->section->name ?? "" }}
                                </td>
                                <td>{{ $student->first_name }}</td>
                                <td>{{ $student->middle_name }}</td>
                                <td>{{ $student->last_name }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showStudent" data-href="{{ route('students.show',$student->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editStudent" data-href="{{ route('students.edit',$student->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                        @if ($student->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('students.restore', $student->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('students.destroy', $student->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                        @endif
                                    </td>
                                @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @role('System Administrator')
                    @if(config('app.env') == 'local')
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                Insert Dummy Student
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('dummy_identity.insert_student') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <hr>
                                    <div class="form-group">
                                        <label>Number of Students: </label>
                                        <input class="form-control" type="number" name="number" max="15000" min="1" value="1">
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-danger">Submit</button>					
                                </form>
                            </div>
                        </div>
                    </div>	
                    @endif
                @endrole
            </div>
        </div>
    </section>
</div>
@endsection