<?php

namespace Modules\Admin\Http\Controllers\Api\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Modules\Admin\Transformers\RoleResource;

use Modules\Admin\Http\Requests\CreateRoleRequest;
use Modules\Admin\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-role');
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:update-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->where('name', '<>', 'Super Admin')
            ->orderBy('name')
            ->get();
        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateRoleRequest $request)
    {
        $role = Role::create($request->all());
        return new RoleResource($role);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->all());
        $role->syncPermissions($request->get('permissions'));
        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }

    /** 
     * All  permissions
     */
    public function permissions()
    {
        $permissions = [];
        $_permissions = Permission::orderBy('menu')->orderBy('submenu')->get();
        foreach($_permissions->groupBy('menu') as $menu => $menus) {
            foreach ($menus->groupBy('submenu') as $submenu => $submenus) {
                $permissions[$menu][$submenu] = $submenus;
            }
        }

        return response()->json(['data' => $permissions]);
    }
}
