<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RolePermissionsController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = "Role";
        $data['roles'] = Role::orderBy('id', 'ASC')->paginate(10);
        return view('master.roles.index', $data)->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $data['title'] = "Role Create";
        $data['permission'] = Permission::get();
        $data['role'] = Role::orderBy('id', 'asc')->get(['id', 'name']);
        return view('master.roles.create', $data);
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'nullable'
            // 'permission' => 'required',
        ]);
        $newRole = Role::updateOrCreate(
            ['name' => strtolower($request->input('name'))],
            [
                'display_name' => $request->input('display_name'),
                'description' => $request->input('description')
            ]
        );
        if ($request->import_from_role != '') {
            $sourceRole = Role::findById($request->input('import_from_role'));

            if ($sourceRole) {
                $permissions = $sourceRole->permissions;
                $newRole->syncPermissions($permissions);
            }
        }
        return redirect()->route('roles')
            ->with('success', 'Role created successfully');
    }


    public function edit(Request $request, $id)
    {
        // return $request->id;
        $data['title'] = "Role Edit";
        $data['role'] = Role::find($id);
        $data['permission'] = Permission::get()->chunk(5);

        $data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        // dd($data['rolePermissions']);
        return view('master.roles.edit', $data);
    }


    public function updatePermission(Request $request)
    {
        $request->validate([
            'roleId' => 'required',
            'permissionId' => 'required',
            'isChecked' => 'required',
        ]);

        $role = Role::findById($request->roleId);
        $permission = Permission::findById($request->permissionId);

        if ($role && $permission) {
            if ($request->isChecked == "1") {
                $role->givePermissionTo($permission);
            } else {
                $role->revokePermissionTo($permission);
            }
            return response()->json(['status' => 'success', 'message' => 'Permission updated successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Role or permission not found.'], 404);
    }

    public function destroy($id)
    {
        $role = Role::where('id', $id)->first();
        if (!$role) {
            return redirect()->route('roles')->with('error', 'Failed to delete the role.');
        }
        $role->delete();
        return redirect()->route('roles')
            ->with('success', 'Role deleted successfully');
    }
}