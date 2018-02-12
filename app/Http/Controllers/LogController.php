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
}