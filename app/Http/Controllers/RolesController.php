<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: RolesController.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:41:00
 */

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $roles = Role::with('perms')->get();
        $perms = (new Permission)->get();
        return view('admin.roles.index', compact('roles', 'perms'));
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
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}