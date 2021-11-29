<?php

namespace App\Http\Controllers;

use App\Models\EvaluationClasses;
use Illuminate\Http\Request;
use App\Charts\EvaluationClassChart;
use App\Exports\EvaluationClassExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacultyEvaluationResult;

class EvaluationClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function show(EvaluationClasses $evaluationClasses)
    {
        $evaluationClassChart = [];
        foreach($evaluationClasses->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses){
            $evaluationClassChart[$questionID] = new EvaluationClassChart;
            $evaluationClassChart[$questionID]->height(250);
            $labels = ['strongly agree','agree','disagree','strongly disagree'];
            $answers = [];
            $finalAnswerCount = [];
            $finalLabels = [];
            foreach($labels as $label){
                $answers[$label] = 0;
            }
            foreach($responses as $response){
                $answers[$response->answer] += 1;
            }
            foreach($labels as $label){
                $finalAnswerCount[] = $answers[$label];
                $finalLabels[] = $label;
            }
            $evaluationClassChart[$questionID]->labels($finalLabels);
            $evaluationClassChart[$questionID]->dataset('responses', 'bar', $finalAnswerCount)->backgroundColor('#007bff')->color('#007bff');
            $evaluationClassChart[$questionID]->options([
                // 'min-height' => '250px',
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'stepSize' => 1,
                        ]
                    ]],
                    'xAxes' => [[
                        'gridLines' => [
                            'display' => true
                        ]
                    ]]
                ]
            ]);
        }
        $data = [
            'evaluationClass' => $evaluationClasses,
            'evaluationClassChart' => $evaluationClassChart,
        ];
        return view('evaluation_classes.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function edit(EvaluationClasses $evaluationClasses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EvaluationClasses $evaluationClasses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EvaluationClasses  $evaluationClasses
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvaluationClasses $evaluationClasses)
    {
        //
    }

    public function export() 
    {
        /* return view('evaluation_classes.excel', [
            'evaluationClass' => EvaluationClasses::find(request()->get('evaluation_class_id'))
        ]); */
        $evaluationClass = EvaluationClasses::find(request()->get('evaluation_class_id'));
        return Excel::download(new EvaluationClassExport(
            $evaluationClass->id), $evaluationClass->id.'-'.$evaluationClass->class->faculty->fullname('').'-'.$evaluationClass->class->course->course_code.'.xlsx'
        );
        // return redirect()->route('evaluations.show', $evaluationClass->evaluation_id);
    }

    public function mailToFaculty(EvaluationClasses $evaluationClasses)
    {
        // echo $evaluationClasses->class->faculty->user->user->email;
        Mail::to('davidpaulsan.18@gmail.com')->send(new FacultyEvaluationResult($evaluationClasses));
        return redirect()->route('evaluations.show', $evaluationClasses->evaluation_id);
    }
}
