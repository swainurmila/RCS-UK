<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\District;
use App\Models\Divisions;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = "Users";
        $data['users'] = User::select('users.*')->with('role:id,name', 'getDistrict:id,name', 'getBlock:id,name')
            ->where('users.is_active', '1')
            ->paginate(10);
        return view('master.user.index', $data)->with('i', ($request->input('page', 1) - 1) * 100);
    }


    public function create()
    {
        $data['title'] = "Users Create";
        $data['roles'] = Role::all();
        $data['division'] = Divisions::all();
        $data['district'] = District::all();
        $data['block'] = Block::all();
        return view('master.user.create', $data);
    }

    public function store(Request $request)
    {
        // return $request;
        // return $request->input('role_id');
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mob_no' => 'required|unique:users,mob_no',
            'age' => 'required',
            'role_id' => 'required',
            'password' => 'required|same:confirm-password',
            'division_id' => 'required',
            'district_id' => 'required',
            'block_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $role = Role::findOrFail($request->role_id);
            $input = [
                'name' => $request->name,
                'email' => $request->email,
                'mob_no' => $request->mob_no,
                'role_id' => $request->role_id,
                'password' => Hash::make($request->password),
                'age' => $request->age,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'block_id' => $request->block_id,
            ];

            $user = User::create($input);
            $user->assignRole($role->name);
            DB::commit();
            return redirect()->route('users-index')
                ->with('success', 'User created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->route('users-index')
                ->with('error', 'Failed to create user');
        }
    }

    public function edit($id)
    {
        $data['title'] = "User Edit";
        $data['user'] = User::find($id);
        $data['roles'] = Role::all();
        $data['division'] = Divisions::all();
        $data['district'] = District::all();
        $data['block'] = Block::all();
        $data['userRole'] = $data['user']->roles->pluck('name', 'name')->all();

        return  view('master.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'mob_no' => 'required|unique:users,mob_no,' . $id,
            'password' => 'same:confirm-password',
            'role_id' => 'required',
            'age' => 'required',
            'division_id' => 'required',
            'district_id' => 'required',
            'block_id' => 'required',
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        $user->save();

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        // $user->assignRole($request->input('roles'));
        $role = Role::findOrFail($request->input('role_id'));
        $user->assignRole($role->name);

        return redirect()->route('users-index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return redirect()->route('users-index')->with('error', 'Failed to delete the User.');
        }
        $user->delete();
        return redirect()->route('users-index')
            ->with('success', 'User deleted successfully');
    }
}