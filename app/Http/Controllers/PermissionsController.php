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
use App\Models\Operator;
use App\Models\Permission;
use App\Services\AppService;
use Illuminate\Http\Request;
use Validator;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public static function index(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $size = 10;
        $search = [
            'name' => isset($request->name) ? $request->name : '',
        ];
        // $perms = (new Permission)->get();
        $permissionListData = Permission::searchPermission($search, $page, $size);
        $pagination = AppService::calculatePagination($page, $size, $permissionListData['count']);
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $data = [];
        $data['perms'] = $permissionListData['permissionList'];
        $data['pagination'] = $pagination;
        $data['search'] = $search;
        $data['operatorList'] = $operatorList;
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/permissions')
                ->withErrors($validator)
                ->withInput();
        }

        $permission = (new Permission())->create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        ActionLog::log(ActionLog::ACTION_CREATE_PERMISSION, isset($permission->display_name) ? $permission->display_name : (isset($permission->name) ? $permission->name : ''));
        return redirect('admin/permissions');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/permissions')
                ->withErrors($validator)
                ->withInput();
        }

        $permission = (new Permission())->findOrFail($id);
        $permission->fill([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ])->save();
        ActionLog::log(ActionLog::ACTION_EDIT_PERMISSION, isset($permission->display_name) ? $permission->display_name : (isset($permission->name) ? $permission->name : ''));
        return redirect('admin/permissions');
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
        return redirect('admin/permissions');
    }

}