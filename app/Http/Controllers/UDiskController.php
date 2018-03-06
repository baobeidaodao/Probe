<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: UDiskController.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 02:46:00
 */

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Operator;
use App\Models\UDisk;
use App\Models\User;
use App\Services\AppService;
use Illuminate\Http\Request;
use Validator;

class UDiskController extends Controller
{
    public static function index(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $size = 10;
        $search = [
            'uuid' => isset($request->uuid) ? $request->uuid : '',
            'user_name' => isset($request->user_name) ? $request->user_name : '',
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
        ];
        // $uDiskListData = UDiskService::listUDisk($page, $size);
        $uDiskListData = UDisk::searchUDisk($search, $page, $size);
        $pagination = AppService::calculatePagination($page, $size, $uDiskListData['count']);
        // $userList = User::all()->toArray();
        $userList = User::listUserForAuth();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $data = [];
        $data['uDiskList'] = $uDiskListData['uDiskList'];
        $data['pagination'] = $pagination;
        $data['userList'] = $userList;
        $data['search'] = $search;
        $data['operatorList'] = $operatorList;
        $data['active'] = 'u-disk';
        return view('admin.u_disk.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|unique:u_disk|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/u-disk')
                ->withErrors($validator)
                ->withInput();
        }

        $uDisk = (new UDisk)->create([
            'uuid' => isset($request->uuid) ? $request->uuid : '',
            'user_id' => isset($request->user_id) ? $request->user_id : 0,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
        ]);
        ActionLog::log(ActionLog::ACTION_CREATE_U_DISK, isset($uDisk->uuid) ? $uDisk->uuid : '');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/u-disk')
                ->withErrors($validator)
                ->withInput();
        }

        $uDisk = (new UDisk())->findOrFail($id);
        $uDisk->fill([
            'uuid' => $request->uuid,
            'user_id' => $request->user_id,
            'operator_id' => $request->operator_id,
        ])->save();
        ActionLog::log(ActionLog::ACTION_EDIT_U_DISK, isset($uDisk->uuid) ? $uDisk->uuid : '');
        return redirect('admin/u-disk');
    }

    public function destroy($id)
    {
        $uDisk = (new UDisk())->findOrFail($id);
        try {
            $uDisk->delete();
            ActionLog::log(ActionLog::ACTION_DELETE_U_DISK, isset($uDisk->uuid) ? $uDisk->uuid : '');
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/u-disk');
    }

}