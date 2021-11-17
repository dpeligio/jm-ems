<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationFaculty;
use App\Models\EvaluationStudent;
use App\Models\EvaluationStudentResponse;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Charts\EvaluationFacultyChart;
use App\Charts\SampleChart;
use Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations = Evaluation::select('*');

        if(Auth::user()->hasrole('Student')){
            $data = [
                'evaluations' => $evaluations->get()
            ];
            return view('evaluations.student_index', $data);
        }elseif(Auth::user()->hasrole('Faculty')){
            $facultyEvaluationChart = [[]];
            $facultyEvaluations = EvaluationFaculty::where([
                ['faculty_id', Auth::user()->faculty->faculty_id],
            ])->orderBy('created_at', 'DESC')->get();
            foreach($facultyEvaluations as $facultyEvaluation){
                $evaluationStudents = EvaluationStudent::where([
                    ['evaluation_faculty_id', $facultyEvaluation->id]
                ])->get('id');

                $evaluationStudentResponses = EvaluationStudentResponse::whereIn('evaluation_student_id', $evaluationStudents);
                // foreach($evaluationStudentResponses->get()->groupBy('question_id') as $questionID => $responses){
                foreach($facultyEvaluation->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses){
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID] = new EvaluationFacultyChart;
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->height(250);
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
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->labels($finalLabels);
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->dataset('responses', 'bar', $finalAnswerCount)->backgroundColor('#007bff')->color('#007bff');
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->options([
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
            }
            $data = [
                'facultyEvaluations' => $facultyEvaluations,
                'facultyEvaluationChart' => $facultyEvaluationChart,
                // 'evaluationChartIDs' => $evaluationChartIDs
            ];
            return view('evaluations.faculty_index', $data);
        }else{
            $data = [
                'evaluations' => $evaluations->get()
            ];
            return view('evaluations.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()) {
            $data = [
                'faculties' => Faculty::get()
            ];

            return response()->json([
                'modal_content' => view('evaluations.create', $data)->render()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'faculties' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $now = Carbon::now();
        $start_date = Carbon::parse($request->get('start_date'));
        $end_date = Carbon::parse($request->get('end_date'));
        $status = 'incoming';

        if($start_date->lt($now) && $end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($end_date->lt($now)){
            $status = 'ended';
        }

        $evaluation = Evaluation::create([
            'title' => $request->get('title'),
            'status' => $status,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'description' => $request->get('description'),
        ]);

        if($request->get('faculties')) {
            $faculties = $request->get('faculties');
            foreach($faculties as $faculty_id){
                EvaluationFaculty::create([
                    'evaluation_id' => $evaluation->id,
                    'faculty_id' => $faculty_id,
                ]);
            }
        }

        return redirect()->route('evaluations.index')->with('alert-success', 'saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        $facultyEvaluationChart = [[]];
        foreach($evaluation->evaluationFaculties as $facultyEvaluation){
            $evaluationStudents = EvaluationStudent::where([
                ['evaluation_faculty_id', $facultyEvaluation->id]
            ])->get('id');

            $evaluationStudentResponses = EvaluationStudentResponse::whereIn('evaluation_student_id', $evaluationStudents);
            // foreach($evaluationStudentResponses->get()->groupBy('question_id') as $questionID => $responses){
            if($evaluationStudents->count() > 0){
                foreach($facultyEvaluation->evaluationStudentResponses()->groupBy('question_id') as $questionID => $responses){
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID] = new EvaluationFacultyChart;
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->height(250);
                    // $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->minHeight(250);
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
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->labels($finalLabels);
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->dataset('responses', 'bar', $finalAnswerCount)->backgroundColor('#007bff')->color('#007bff');
                    $facultyEvaluationChart[$facultyEvaluation->id][$questionID]->options([
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
            }
        }
        $data = [
            'evaluation' => $evaluation,
            'facultyEvaluationChart' => $facultyEvaluationChart,
            // 'evaluationChartIDs' => $evaluationChartIDs
        ];
        return view('evaluations.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        if(request()->ajax()) {
            return response()->json([
                'modal_content' => view('evaluations.edit', compact('evaluation'))->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'faculty' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $now = Carbon::now();
        $start_date = Carbon::parse($request->get('start_date'));
        $end_date = Carbon::parse($request->get('end_date'));
        $status = 'incoming';

        if($start_date->lt($now) && $end_date->gt($now)){
            $status = 'ongoing';
        }
        elseif($end_date->lt($now)){
            $status = 'ended';
        }

        $evaluation->update([
            'title' => $request->get('title'),
            'status' => $status,
            'faculty_id' => $request->get('faculty'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'description' => $request->get('description'),
        ]);

        return redirect()->route('evaluations.index')->with('alert-success', 'saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
	{
		if (request()->get('permanent')) {
			$evaluation->forceDelete();
		}else{
			$evaluation->delete();
		}
		return redirect()->route('evaluations.index')->with('alert-danger','Deleted');
	}

	public function restore($evaluation)
	{
		$evaluation = Evaluation::withTrashed()->find($evaluation);
		$evaluation->restore();
		return redirect()->route('evaluations.index')->with('alert-success','Restored');
	}
}
