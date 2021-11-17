@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> {{ $evaluation->title }} </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn btn-default" href="{{ route('evaluations.index') }}" ><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col" id="accordion">
                @foreach ($evaluation->evaluationFaculties as $index => $facultyEvaluation)
                    <div class="card @if($facultyEvaluation->trashed()) card-danger @else card-primary @endif card-outline">
                        <a class="d-block" data-toggle="collapse" href="#evaluation-{{ $facultyEvaluation->id }}">
                            <div class="card-header d-flex p-0">
                                <h4 class="card-title p-3 text-dark">
                                    {{ $facultyEvaluation->faculty->fullname('') }}
                                </h4>
                                {{-- <ul class="nav nav-pills ml-auto p-2">
                                    @if ($facultyEvaluation->trashed())
                                        @can('evaluations.restore')
                                        <li class="nav-item">
                                            <a class="nav-link text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('evaluations.restore', $facultyEvaluation->id) }}"><i class="fad fa-download"></i> Restore</a>
                                        </li>
                                        @endcan
                                    @else
                                        @can('evaluations.destroy')
                                        <li class="nav-item">
                                            <a class="nav-link text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('evaluations.destroy', $facultyEvaluation->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
                                        </li>
                                        @endcan
                                    @endif
                                    @can('evaluations.edit')
                                    <li class="nav-item">
                                        <a class="nav-link text-primary" href="{{ route('evaluations.edit', $facultyEvaluation->id) }}"><i class="fad fa-edit"></i> Edit</a>
                                    </li>
                                    @endcan
                                </ul> --}}
                            </div>
                        </a>
                        <div id="evaluation-{{ $facultyEvaluation->id }}" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    <div class="row">
                                        @forelse ($facultyEvaluation->evaluationStudentResponses()->groupBy('question') as $question => $responses)
                                            @foreach ($responses->groupBy('question_id') as $questionID => $response)
                                                <div class="col-md-3">
                                                    <div class="card">
                                                        <div class="card-header border-0">
                                                            <div class="d-flex justify-content-between">
                                                                <h5 class="card-title">{{ $question }}</h5>
                                                                {{-- <a href="javascript:void(0);">View Report</a> --}}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="position-relative mb-4">
                                                                {!! $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->container() !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach 
                                        @empty
                                        <div class="col-md-12">
                                            <div class="alert alert-warning text-center">No Records yet</div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
{{-- @for ($i = 0; $i < $countGraph; $i++)
    {!! $facultyEvaluationChart[$facultyEvaluationChartIDs[$i]]->script() !!}
@endfor --}}
{{-- @foreach ($facultyEvaluationChartIDs as $facultyEvaluationChartIDs)
    {!! $facultyEvaluationChart[$facultyEvaluationChartIDs]->script() !!}
@endforeach --}}
@if($evaluation->evaluationFaculties->count() > 0)
    @foreach ($evaluation->evaluationFaculties as $facultyEvaluation)
        @foreach ($facultyEvaluation->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses)
            {{-- @foreach ($responses->groupBy('question_id') as $questionID => $response) --}}
                {!! $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->script() !!}
            {{-- @endforeach --}}
            <script>
                // var chart = $('#{{ $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->id }}');
                var renderChart = new Chart(window.{{ $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->id }}, {
                    // type: 'bar',
                    options: {
                        'min-height': '250px',
                    }
                })
            </script>
        @endforeach
    @endforeach
    
    {{-- @foreach ($evaluation->evaluationFaculties as $facultyEvaluation)
        @if($facultyEvaluation->evaluationStudentResponses()->count() > 0)
        <script>
            $(function(){
                $('#evaluation-{{ $facultyEvaluation->id }}').addClass('show')
            })
        </script>
        @endif
    @endforeach --}}
@endif
   
@endsection