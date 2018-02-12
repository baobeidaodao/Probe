<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: PermissionsController.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:43:00
 */

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $perms = (new Permission)->get();
        $data = [];
        $data['perms'] = $perms;
        $data['active'] = 'permissions';
        return view('admin.permissions.index', $data);
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
    public function store(Request $request)
    {
        $permission = (new Permission())->create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        ActionLog::log(ActionLog::ACTION_CREATE_PERMISSION, isset($permission->display_name) ? $permission->display_name : (isset($permission->name) ? $permission->name : ''));
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
        $permission = (new Permission())->findOrFail($id);
        $permission->fill([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ])->save();
        ActionLog::log(ActionLog::ACTION_EDIT_PERMISSION, isset($permission->display_name) ? $permission->display_name : (isset($permission->name) ? $permission->name : ''));
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
        $permission = (new Permission())->findOrFail($id);
        // $role->perms()->detach();
        try {
            $permission->delete();
            ActionLog::log(ActionLog::ACTION_DELETE_PERMISSION, isset($permission->display_name) ? $permission->display_name : (isset($permission->name) ? $permission->name : ''));
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}