<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Hash;
use Arr;
use DB;
use Log;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\Welcome;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $user = User::get();
        return view('admin.users.index', [
            'users' => $user,
        ]);
    }

    public function create()
    {
        $user = User::all();
        $roles = Role::select('id','name')->get();
        return view('admin.users.create', [
            'users' => $user,
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
{
    try {
        DB::beginTransaction();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $input = $request->except('roles');
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);

        $roles = $request->input('roles');
        $user->assignRole($roles);

        DB::commit();

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');

    } catch (\Exception $e) {
        DB::rollback();

        // Detailed logging
        Log::error('User creation failed', ['error' => $e->getMessage(),
        ]);

        return redirect()->back()->with('error', 'An error occurred while creating the user. Please try again or contact support for assistance.');
    }
}

    //User Show
    public function show($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->getRoleNames();

        return view('users.show', compact('user', 'roles'));
    }

    public function edit($id)
    {

        $user = User::find($id);
        $roles = Role::select('id', 'name')->get();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    //User Update
    public function update(Request $request, $id)
    {
        // Validate the request
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:8|confirmed',
            'roles' => 'required'
        ]);

        // Get all request data
        $input = $request->all();

        // If password is not empty, hash it
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            // Exclude password from input if not being updated
            $input = Arr::except($input, ['password']);
        }


        $user = User::find($id);
        $user->update($input);


        $roles = $request->input('roles');


        // Sync roles with the user
        $user->syncRoles($roles);

        // Redirect with success message
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    // $adminRole = Role::create(['name' => 'admin']);
    // $userRole = Role::create(['name' => 'user']);
    // $user = User::find(1);
    // $user->assignRole('admin');

}
