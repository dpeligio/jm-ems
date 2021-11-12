<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('student_register', [
	'as' => 'student_registration.register',
	'uses' => 'StudentRegistrationController@register'
]);

Route::group(array('middleware'=>['auth']), function() {

    /**
	 * Roles and Permissions
	 */
    Route::resource('roles', 'Configuration\RolePermission\RoleController');
	// Route::get('/roles_get_data', 'Configuration\RolePermission\RoleController@get_data')->name('roles.get_data');
	// restore
	Route::post('roles/restore/{department}', [
		'as' => 'roles.restore',
		'uses' => 'Configuration\RolePermission\RoleController@restore'
	]);
	
	/**
	 * Users
	 */
	Route::resource('users', 'UserController');
	// validate user/student
	Route::get('user_activate/{user}', [
		'as' => 'users.activate',
		'uses' => 'UserController@activate'
	]);
	// restore
	Route::post('users_restore/{user}', [
		'as' => 'users.restore',
		'uses' => 'UserController@restore'
	]);
    
    Route::resource('permissions', 'Configuration\RolePermission\PermissionController');
	// Route::get('/permissions_get_data', 'Configuration\RolePermission\PermissionController@get_data')->name('permissions.get_data');
	// restore
	Route::post('permissions/restore/{department}', [
		'as' => 'permissions.restore',
		'uses' => 'Configuration\RolePermission\PermissionController@restore'
	]);

	/**
	 * Faculty
	 */
	/* Route::resource('faculties', 'Configuration\FacultyController')->parameters([
		'faculties' => 'faculty'
	]); */
	Route::resource('faculties', 'FacultyController');
	// restore
	Route::post('faculties_restore/{position}', [
		'as' => 'faculties.restore',
		'uses' => 'FacultyController@restore'
	]);

	/**
	 * Student
	 */
	Route::resource('students', 'StudentController');
	// restore
	Route::post('students_restore/{position}', [
		'as' => 'students.restore',
		'uses' => 'StudentController@restore'
	]);

	/**
	 * Question
	 */
	Route::resource('questions', 'QuestionController');
	// restore
	Route::post('questions_restore/{question}', [
		'as' => 'questions.restore',
		'uses' => 'QuestionController@restore'
	]);

	/**
	 * Evaluation
	 */
	Route::resource('evaluations', 'EvaluationController');
	// restore
	Route::post('evaluations_restore/{evaluation}', [
		'as' => 'evaluations.restore',
		'uses' => 'EvaluationController@restore'
	]);
	
});
/**	
 * Dev
 */
Route::post('insert_student', ['as' => 'dummy_identity.insert_student', 'uses' => 'RandomIdentityController@insert_student']);
Route::post('insert_faculty', ['as' => 'dummy_identity.insert_faculty', 'uses' => 'RandomIdentityController@insert_faculty']);
