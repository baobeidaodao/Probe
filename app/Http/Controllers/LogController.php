<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: LogController.php
 * Author  : Li Tao
 * DateTime: 2018-02-12 06:41:00
 */

namespace App\Http\Controllers;

use App\Services\ActionLogService;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public static function index($page = 1)
    {
        $size = 10;
        $actionLogData = ActionLogService::listActionLog($page, $size);
        $data = [];
        $data['actionLogList'] = $actionLogData['actionLogList'];
        $data['pagination'] = $actionLogData['pagination'];
        $data['active'] = 'logs';
        return view('admin.logs.index', $data);
    }

    public static function search($page = 1, Request $request){
        $size = 10;
        $search = [
            'user_name' => isset($request->user_name) ? $request->user_name : '',
            'start_date' => isset($request->start_date) ? $request->start_date : '',
            'end_date' => isset($request->end_date) ? $request->end_date : '',
        ];
        $actionLogData = ActionLogService::searchActionLog($search, $page, $size);
        $data = [];
        $data['actionLogList'] = $actionLogData['actionLogList'];
        $data['search'] = $search;
        $data['pagination'] = $actionLogData['pagination'];
        $data['active'] = 'logs';
        return view('admin.logs.index', $data);
    }

}