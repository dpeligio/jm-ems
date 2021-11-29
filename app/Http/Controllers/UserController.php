<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Configuration\RolePermission\Role;
use App\Models\Configuration\RolePermission\UserRole;
use App\Models\UserFaculty;
use App\Models\UserStudent;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountVerified;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users.index', ['only' => ['index']]);
        $this->middleware('permission:users.create', ['only' => ['create','store']]);
        $this->middleware('permission:users.show', ['only' => ['show']]);
        $this->middleware('permission:users.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$users->withTrashed();
		}else{
			$users->where('id', '!=', '1');
		}
		
		$data = [
			'users' => $users->get()
		];
		return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('*');
		if(Auth::user()->hasrole('System Administrator')){
			$roles = $roles;
		}elseif(Auth::user()->hasrole('Administrator')){
			$roles->where('id', '!=', 1)->get();
		}else{
			$roles->whereNotIn('id', [1,2]);
        }

		$data = [
			'roles' => $roles->get(),
		];

		if(request()->ajax()){
			return response()->json([
				'modal_content' => view('users.create', $data)->render()
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
			'user_id' => ['required'],
			'role' => ['required'],
			'username' => ['required', 'string', 'max:255', 'unique:users,username'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
		$user = User::create([
			'username' => $request->get('username'),
			'email' => $request->get('email'),
			'password' => Hash::make($request->get('password')),
        ]);
        
        $user->assignRole($request->role);
        
        if($request->get('type') == 'student') {
            UserStudent::create([
                'user_id' => $user->id,
                'student_id' => $request->get('user_id')
            ]);
        }else{
            UserFaculty::create([
                'user_id' => $user->id,
                'faculty_id' => $request->get('user_id')
            ]);
        }
		return back()->with('alert-success', 'Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if(request()->ajax()){
            $data = [
                'user' => $user
            ];
            return response()->json([
                'modal_content' => view('users.show', $data)->render()
            ]);
        }else{
            return redirect()->rotue('users.index');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
	{
        if($user->id != 1){
            if (request()->get('permanent')) {
                $user->forceDelete();
            }else{
                $user->delete();
            }
            return redirect()->route('users.index')->with('alert-danger','Deleted');
        }else{
            return redirect()->route('users.index')->with('alert-danger','You cannot delete System Administrator');
        }
	}

	public function restore($user)
	{
		$user = User::withTrashed()->find($user);
		$user->restore();
		return redirect()->route('users.index')->with('alert-success','Restored');
    }
    
    public function activate(User $user)
    {
        Mail::to($user->email)->send(new AccountVerified($user));
        $user->update([
            'is_verified' => 1
        ]);
        return redirect()->route('users.index')->with('alert-success', 'saved');
    }

    public function accountSettings(User $user)
    {
        return view('users.account_settings', compact('user'));
    }
}
