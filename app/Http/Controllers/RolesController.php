<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: RolesController.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:41:00
 */

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
        // $this->middleware('permission:edit_role', ['only' => 'update']);
        $this->middleware('ability:admin, edit_role', ['only' => 'update']);
        // $this->middleware('permission:delete_role', ['only' => 'destroy']);
        $this->middleware(['ability:admin, delete_role', 'protect.admin.role'], ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return \Illuminate\Http\Response
     */
    public static function index($page = 1)
    {
        $size = 10;
        // $roles = Role::with('perms')->get();
        $roleListData = Role::listRole($page, $size);
        $pagination = AppService::calculatePagination($page, $size, $roleListData['count']);
        $perms = (new Permission)->get();
        $data = [];
        $data['roles'] = $roleListData['roleList'];
        $data['perms'] = $perms;
        $data['pagination'] = $pagination;
        $data['active'] = 'roles';
        return view('admin.roles.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request)
    {
        $role = (new Role)->create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        if ($request->perm) {
            $role->attachPermissions($request->perm);
        }
        ActionLog::log(ActionLog::ACTION_CREATE_ROLE, isset($role->display_name) ? $role->display_name : (isset($role->name) ? $role->name : ''));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = (new Role)->findOrFail($id);
        $role->fill([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ])->save();
        $role->savePermissions($request->perm);
        ActionLog::log(ActionLog::ACTION_EDIT_ROLE, isset($role->display_name) ? $role->display_name : (isset($role->name) ? $role->name : ''));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = (new Role)->findOrFail($id);
        // $role->perms()->detach();
        try {
            $role->delete();
            ActionLog::log(ActionLog::ACTION_DELETE_ROLE, isset($role->display_name) ? $role->display_name : (isset($role->name) ? $role->name : ''));
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    public static function search($page = 1, Request $request){
        $size = 10;
        $search = [
            'name' => isset($request->name) ? $request->name : '',
        ];
        $roleListData = Role::searchRole($search, $page, $size);
        $pagination = AppService::calculatePagination($page, $size, $roleListData['count']);
        $perms = (new Permission)->get();
        $data = [];
        $data['roles'] = $roleListData['roleList'];
        $data['perms'] = $perms;
        $data['pagination'] = $pagination;
        $data['search'] = $search;
        $data['active'] = 'roles';
        return view('admin.roles.index', $data);
    }

}