<?php

namespace Modules\Admin\Http\Controllers\Api\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Admin\Entities\Admin;
use Modules\Admin\Transformers\AdminResource;

use Modules\Admin\Http\Requests\CreateAdminRequest;
use Modules\Admin\Http\Requests\UpdateAdminRequest;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-admin');
        $this->middleware('permission:create-admin', ['only' => ['create','store']]);
        $this->middleware('permission:update-admin', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-admin', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $admins = Admin::with('roles')->latest()->get();
        return AdminResource::collection($admins);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateAdminRequest $request)
    {
        $admin = Admin::create($request->all());
        $admin->assignRole($request->role_id);
        $admin->load('roles');
        return new AdminResource($admin);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Admin $admin)
    {
        $admin->load('roles');
        return new AdminResource($admin);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $admin->update($request->all());
        $admin->assignRole($request->role_id);
        $admin->load('roles');
        return new AdminResource($admin);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return response()->json(null, 204);
    }
}
