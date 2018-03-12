<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: LogController.php
 * Author  : Li Tao
 * DateTime: 2018-02-12 06:41:00
 */

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Operator;
use App\Services\AppService;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public static function index(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $size = 10;
        $search = [
            'user_name' => isset($request->user_name) ? $request->user_name : '',
            'start_date' => isset($request->start_date) ? $request->start_date : '',
            'end_date' => isset($request->end_date) ? $request->end_date : '',
        ];
        // $actionLogData = ActionLogService::listActionLog($page, $size);
        $actionLogData = ActionLog::searchActionLog($search, $page, $size);
        $actionLogList = $actionLogData['actionLogList'];
        foreach ($actionLogList as $index => $actionLog) {
            $actionLogList[$index]['action_name'] = ActionLog::$actionMap[$actionLog['action']];
        }
        $pagination = AppService::calculatePagination($page, $size, $actionLogData['count']);
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $data = [];
        $data['actionLogList'] = $actionLogList;
        $data['pagination'] = $pagination;
        $data['search'] = $search;
        $data['operatorList'] = $operatorList;
        $data['active'] = 'logs';
        return view('admin.logs.index', $data);
    }

}