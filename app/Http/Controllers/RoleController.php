<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    function role(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('admin.role.index', [
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }
    function permission_store(Request $request){
        $permission = Permission::create(['name' => $request->permission_name]);
        return back();
    }
    function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return back();
    }
    function role_assign(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role);
        return back();
    }

    function role_edit($user_id){
        $role_info = User::find($user_id);
        $permissions = Permission::all();
        return view('admin.role.edit', [
            'role_info'=>$role_info,
            'permissions'=>$permissions,
        ]);
    }
    
    function role_update(Request $request){
        $user = User::find($request->user_id);
        $user->syncPermissions($request->permission);
    }
    
}
