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
use App\Models\Operator;
use App\Models\Permission;
use App\Models\ReportConfig;
use App\Models\User;
use App\Models\UserLevel;
use App\Services\AdminService;
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
        $ipOperatorList = (new Operator())->where('level', '=', Operator::LEVEL_1)->get()->toArray();
        $uDiskOperatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $operatorIdLevel = ReportConfig::operatorIdLevel();
        //$operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $areaMap = AdminService::listAreaMapForUser();
        $data = [];
        $data['active'] = 'admin';
        $data['areaMap'] = $areaMap;
        $data['ipOperatorList'] = $ipOperatorList;
        $data['uDiskOperatorList'] = $uDiskOperatorList;
        //$data['operatorList'] = $operatorList;
        $data['operatorIdLevel'] = $operatorIdLevel;
        return view('admin.admin', $data);
    }

    public static function updateStatistics(Request $request)
    {
        $update = [
            'start_date' => isset($request->start_date) ? $request->start_date : '',
            'end_date' => isset($request->end_date) ? $request->end_date : '',
        ];
        StatisticsService::storageOfDate($update['start_date'], $update['end_date']);
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        ActionLog::log(ActionLog::ACTION_UPDATE_STATISTICS, $update['start_date'] . ' ~ ' . $update['end_date']);
        $data = [];
        $data['update'] = $update;
        $data['active'] = 'admin';
        $data['operatorList'] = $operatorList;
        //return view('admin.index', $data);
        return redirect('admin');
    }

    public static function updateReportConfig(Request $request)
    {
        $operatorIdLevel1 = isset($request->operator_id_level_1) ? $request->operator_id_level_1 : 0;
        $reportConfig = (new ReportConfig)->where('option', '=', 'operator_id_level_1')->first();
        $reportConfig->value = $operatorIdLevel1;
        $reportConfig->save();
        $operatorIdLevel2 = isset($request->operator_id_level_2) ? $request->operator_id_level_2 : 0;
        $reportConfig = (new ReportConfig)->where('option', '=', 'operator_id_level_2')->first();
        $reportConfig->value = $operatorIdLevel2;
        $reportConfig->save();
        return redirect('admin');
    }

}