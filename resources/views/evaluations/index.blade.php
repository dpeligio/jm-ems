@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Evaluations</h1>
            </div>
            <div class="col-sm-6 text-right">
                @can('evaluations.create')
                    <button class="btn btn-default" type="button" data-toggle="modal-ajax" data-href="{{ route('evaluations.create') }}" data-target="#createEvaluation"><i class="fa fa-plus"></i> Add</button>
                @endcan
            </div>
        </div>
    </div>

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
                                <th>Status</th>
                                <th>Evaluation</th>
                                @role('System Administrator')
                                <th class="text-center">Action</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evaluations as $evaluation)
                            <tr @unlessrole('System Administrator') @can('evaluations.show') data-toggle="modal-ajax" data-target="#showEvaluation" data-href="{{ route('evaluations.show', $evaluation->id) }}"  @endcan @else class="{{ $evaluation->trashed() ? 'table-danger' : '' }}" @endunlessrole>
                                @role('System Administrator')
                                <td>{{ $evaluation->id }}</td>
                                @endrole
                                <td>{{ $evaluation->status }}</td>
                                <td>{{ $evaluation->evaluation }}</td>
                                @role('System Administrator')
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showEvaluation" data-href="{{ route('evaluations.show',$evaluation->id) }}"><i class="fad fa-file fa-lg"></i></a>
                                        {{-- <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editEvaluation" data-href="{{ route('evaluations.edit',$evaluation->id) }}"><i class="fad fa-edit fa-lg"></i></a> --}}
                                        @if ($evaluation->trashed())
                                            <a class="text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('evaluations.restore', $evaluation->id) }}"><i class="fad fa-download fa-lg"></i></a>
                                        @else
                                            <a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('evaluations.destroy', $evaluation->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
                                        @endif
                                    </td>
                                @endrole
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection