<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\User;
use App\Models\UserStudent;
use App\Models\FileAttachment;
use App\Models\UserFileAttachment;

class StudentRegistrationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
			'school_id' => 'required',
			'student_id' => ['required', 'unique:students,student_id', 'unique:users,username'],
			'year_level' => 'required',
			'first_name' => 'required',
			'middle_name' => 'required',
			'last_name' => 'required',
            'gender' => 'required',
            // 'contact_number' => ['unique:students,contact_number'],
            // 'student_id' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

		$student = Student::create([
			'year_level' => $request->get('year_level'),
			'student_id' => $request->get('student_id'),
			'first_name' => $request->get('first_name'),
			'middle_name' => $request->get('middle_name'),
			'last_name' => $request->get('last_name'),
			'gender' => $request->get('gender'),
			// 'contact_number' => $request->get('contact_number'),
			'address' => $request->get('address'),
        ]);

        $user = User::create([
            'username' => $request->get('student_id'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);

        $user->assignRole(4);

        $file = $request->file('school_id');
        $mimeType = $file->getClientMimeType();
        $fileName = 'School ID validation'.'_'.date('m-d-Y H.i.s').'.'.$file->getClientOriginalExtension();

        $file_attachment = FileAttachment::create([
            'subject' => 'School ID validation',
            'mime_type' => $mimeType,
            'file_extension' => $file->getClientOriginalExtension(),
            'file_path' => $file->path(),
            'file_type' => explode("/", $mimeType)[0],
            'file_name' => $fileName,
            // 'data' => $blob,
        ]);

        $userFileAttachment = UserFileAttachment::create([
            'user_id' => $user->id,
            'file_attachment_id' => $file_attachment->id,
        ]);
        $uploadPath = 'File Attachments/School ID Validation/';
        $file_attachment->update(['file_path' => $uploadPath]);
        Storage::disk('upload')->putFileAs($uploadPath, $file, $fileName);

        UserStudent::create([
            'user_id' => $user->id,
            'student_id' => $student->id
        ]);

		return back()->with('alert-success', 'Saved');
    }
}
