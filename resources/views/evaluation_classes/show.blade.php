@extends('layouts.adminlte')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $evaluationClass->class->course->course_code }} - {{ $evaluationClass->class->course->title }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn btn-default" href="{{ route('evaluations.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            @forelse ($evaluationClass->evaluationStudentResponses()->groupBy('question') as $question => $responses)
                @foreach ($responses->groupBy('question_id') as $questionID => $response)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $question }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="position-relative mb-4">
                                    {!! $evaluationClassChart[$questionID]->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
            <div class="col">
                <div class="alert alert-warning text-center">No Records yet</div>
            </div>
            @endforelse
        </div>
        <div class="row">
            <div class="col">
                <legend>Student Comments</legend>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Positive Comment</th>
                            <th>Negative Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($evaluationClass->evaluationStudents as $studentResponse)
                            <tr>
                                <td>
                                    {{ $studentResponse->positive_comments }}
                                </td>
                                <td>
                                    {{ $studentResponse->negative_comments }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center text-danger" colspan="2">*** No records yet ***</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
    @foreach ($evaluationClass->evaluationStudentResponses()->groupBy('question') as $question => $responses)
        @foreach ($responses->groupBy('question_id') as $questionID => $response)
        {!! $evaluationClassChart[$questionID]->script() !!}
        @endforeach 
    @endforeach
@endsection