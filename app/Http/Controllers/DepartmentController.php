<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: DepartmentController.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 08:55:00
 */

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Area;
use App\Models\Department;
use App\Services\AdminService;
use App\Services\AppService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $page
     * @return \Illuminate\Http\Response
     */
    public static function index($page = 1)
    {
        $size = 10;
        $departmentListData = AdminService::listDepartment($page, $size);
        $pagination = AppService::calculatePagination($page, $size, $departmentListData['count']);
        $areaMap = AdminService::listAreaMap();
        $cityList = Area::listCity();
        $data = [];
        $data['departmentList'] = $departmentListData['departmentList'];
        $data['pagination'] = $pagination;
        $data['areaMap'] = $areaMap;
        $data['cityList'] = $cityList;
        $data['active'] = 'department';
        return view('admin.department.index', $data);
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
        $department = (new Department())->create([
            'name' => $request->name,
            'area_id' => $request->city_id,
        ]);
        ActionLog::log(ActionLog::ACTION_CREATE_DEPARTMENT, isset($department->name) ? $department->name : '');
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
        $department = (new Department())->findOrFail($id);
        $department->fill([
            'name' => $request->name,
            'area_id' => $request->city_id,
        ])->save();
        ActionLog::log(ActionLog::ACTION_EDIT_DEPARTMENT, isset($department->name) ? $department->name : '');
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
        $department = (new Department())->findOrFail($id);
        try {
            $department->delete();
            ActionLog::log(ActionLog::ACTION_DELETE_DEPARTMENT, isset($department->name) ? $department->name : '');
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    public static function search($page = 1, Request $request)
    {
        $size = 10;
        $search = [
            'name' => isset($request->name) ? $request->name : '',
            'area_id' => (isset($request->city_id) && !empty($request->city_id)) ? $request->city_id : ((isset($request->province_id) && !empty($request->province_id)) ? $request->province_id : 0),
        ];
        $departmentListData = Department::searchDepartment($search, $page, $size);
        $pagination = AppService::calculatePagination($page, $size, $departmentListData['count']);
        $areaMap = AdminService::listAreaMap();
        $cityList = Area::listCity();
        $data = [];
        $data['departmentList'] = $departmentListData['departmentList'];
        $data['pagination'] = $pagination;
        $data['search'] = $search;
        $data['areaMap'] = $areaMap;
        $data['cityList'] = $cityList;
        $data['active'] = 'department';
        return view('admin.department.index', $data);
    }

}