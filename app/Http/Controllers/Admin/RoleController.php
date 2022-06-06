<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function assignPermissions(Request $request, Role $role)
    {
//        dd($request->all());
        $permission = Permission::whereIn('id', $request->all()['permissions'])->get();
        $role->syncPermissions($permission);

        return response()->json(['role' => $role]);
    }
}
