<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\CreatePermissionRequest;
use App\Http\Requests\Admin\Permissions\UpdatePermissionRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function create (CreatePermissionRequest $request)
    {
        $validated = $request->validated();
        $validated['guard_name'] = 'web';
        $permission = Permission::create($validated);
        return response()->json(['permission' => $permission]);
    }

    public function destroy (Permission $permission)
    {
        $permission->delete();
        return response()->json(['message'=>'deleted']);
    }

    public function update (UpdatePermissionRequest $request, Permission $permission) {
        $data = $request->validated();
        $permission->update($data);
    }
}
