<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassStudent;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::select('*');
        $data = [
            'classes' => $classes->get()
        ];

        return view('classes.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $data = [
                'courses' => Course::get(),
                'faculties' => Faculty::get(),
                'students' => Student::get(),
            ];
            return response()->json([
                'modal_content' => view('classes.create', $data)->render()
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
            'faculty' => 'required',
            // 'section' => 'required',
        ]);

        $class = Classes::create([
            'is_active'=> true,
            'course_id'=> $request->get('course'),
            'faculty_id'=> $request->get('faculty'),
            'section'=> $request->get('section'),
            'school_year'=> $request->get('school_year'),
            'schedule'=> $request->get('schedule'),
        ]);

        if($request->get('students')){
            foreach($request->get('students') as $studentID){
                ClassStudent::create([
                    'class_id' => $class->id,
                    'student_id' => $studentID,
                ]);
            }
        }

        return redirect()->route('classes.index')->with('alert-success', 'Saved');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classes $classes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $classes)
	{
		if (request()->get('permanent')) {
			$classes->forceDelete();
		}else{
			$classes->delete();
		}
		return redirect()->route('classes.index')->with('alert-danger','Deleted');
	}

	public function restore($classes)
	{
		$classes = Classes::withTrashed()->find($classes);
		$classes->restore();
		return redirect()->route('classes.index')->with('alert-success','Restored');
    }

    public function setActive(Classes $classes)
    {
        $classes->update([
            'is_active' => false
        ]);
        return redirect()->route('classes.index')->with('alert-success', 'Saved');
    }

    public function setInactive(Classes $classes)
    {
        $classes->update([
            'is_active' => true
        ]);
        return redirect()->route('classes.index')->with('alert-success', 'Saved');
    }
}
