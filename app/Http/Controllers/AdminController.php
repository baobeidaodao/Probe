<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: AdminController.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:03:00
 */

namespace App\Http\Controllers;


use App\Models\ActionLog;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserLevel;
use App\Services\StatisticsService;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public static function index()
    {
        $user = Auth::user();
        $permission = Permission::userHasPermission($user->id, 'login');
        if (!$permission) {
            abort(403);
        }
        $data = [];
        $data['active'] = 'admin';
        return view('admin.index', $data);
    }

    public static function updateStatistics(Request $request)
    {
        $update = [
            'start_date' => isset($request->start_date) ? $request->start_date : '',
            'end_date' => isset($request->end_date) ? $request->end_date : '',
        ];
        StatisticsService::storageOfDate($update['start_date'], $update['end_date']);
        ActionLog::log(ActionLog::ACTION_UPDATE_STATISTICS, $update['start_date'] . ' ~ ' . $update['end_date']);
        $data = [];
        $data['update'] = $update;
        $data['active'] = 'admin';
        return view('admin.index', $data);
    }
}