<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: ActionLogService.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 10:42:00
 */

namespace App\Services;

use App\Models\ActionLog;

class ActionLogService
{
    public static function listActionLog($page = 1, $size = 10)
    {
        $data = ActionLog::listActionLog($page, $size);
        $data = AppService::objectToArray($data);
        $actionLogList = $data['actionLogList'];
        foreach ($actionLogList as $index => $actionLog) {
            $actionLogList[$index]['action_name'] = ActionLog::$actionMap[$actionLog['action']];
        }
        $pagination = AppService::calculatePagination($page, $size, $data['count']);
        $data['actionLogList'] = $actionLogList;
        $data['pagination'] = $pagination;
        return $data;
    }
}