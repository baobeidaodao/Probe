<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: StatisticsService.php
 * Author  : Li Tao
 * DateTime: 2018-02-26 05:51:00
 */

namespace App\Services;


use App\Models\Ip;
use App\Models\ProbeResultVerified;
use App\Models\Report;
use App\Models\Statistics;
use App\Models\UDisk;

class StatisticsService
{
    public static function storageOfDate($startDate = '', $endDate = '')
    {
        $dateArray = [];
        if (!isset($startDate) || empty($startDate)) {
            $date = date('Y-m-d', strtotime('-1 day'));
            $dateArray[] = $date;
        } else if (!isset($endDate) || empty($endDate)) {
            $dateArray[] = $startDate;
        } else {
            $startTime = strtotime($startDate);
            $endTime = strtotime($endDate);
            $datetime = $startTime;
            while ($datetime <= $endTime) {
                $dateArray[] = date('Y-m-d', $datetime);
                $datetime = strtotime('+1 day', $datetime);
            }
        }
        foreach ($dateArray as $date) {
            self::storage($date);
        }
    }

    /**
     * 统计数据并入库
     * @author Li Tao
     * @param string $date
     */
    public static function storage($date = '')
    {
        /** 查询前一天的 proberesultverified 数据 */
        if (!isset($date) || empty($date)) {
            $date = date('Y-m-d', strtotime('-1 day'));
        }
        $startDateTime = $date . ' 00:00:00';
        // $startDateTime = '2018-01-01' . ' 00:00:00';
        $endDateTime = $date . ' 23:59:59';
        $probeResultVerifiedList = (new ProbeResultVerified)
            ->whereBetween('dt', [$startDateTime, $endDateTime])
            ->orderBy('dt', 'asc')
            ->get()
            ->toArray();
        $probeResultArray = self::filterProbeResult($probeResultVerifiedList);
        foreach ($probeResultArray as $probeResult) {
            self::storageProbeResult($probeResult);
        }
    }

    /**
     * 过滤上报信息
     * @author Li Tao
     * @param $probeResultList
     * @return array
     */
    private static function filterProbeResult($probeResultList)
    {
        $probeResultArray = [];
        foreach ($probeResultList as $index => $probeResult) {
            if (isset($probeResult['UDiskUuid']) && isset($probeResult['result'])) {
                $result = str_replace(["\r\n", "\r", "\n"], '', $probeResult['result']);
                $probeResultList[$index]['result'] = $result;
                $key = $probeResult['UDiskUuid'] . $result;
                $probeResultArray[$key] = $probeResultList[$index];
            }
        }
        return $probeResultArray;
    }

    /**
     * 存储 报告
     * @author Li Tao
     * @param $probeResult
     */
    private static function storageProbeResult($probeResult)
    {
        $uuid = $probeResult['UDiskUuid'];
        $date = $probeResult['dt'];
        $startDate = date('Y-m-d 00:00:00', strtotime($date));
        $endDate = date('Y-m-d 23:59:59', strtotime($date));
        $uDiskData = UDisk::uDiskData($uuid);
        $statisticsData = [];
        $statisticsData['u_disk_id'] = isset($uDiskData['u_disk_id']) ? $uDiskData['u_disk_id'] : null;
        $statisticsData['uuid'] = $uuid;
        $statisticsData['user_id'] = isset($uDiskData['user_id']) ? $uDiskData['user_id'] : null;
        $statisticsData['user_name'] = isset($uDiskData['user_name']) ? $uDiskData['user_name'] : null;
        $statisticsData['user_phone'] = isset($uDiskData['user_phone']) ? $uDiskData['user_phone'] : null;
        $statisticsData['user_email'] = isset($uDiskData['user_email']) ? $uDiskData['user_email'] : null;
        $statisticsData['user_department_id'] = isset($uDiskData['user_department_id']) ? $uDiskData['user_department_id'] : null;
        $statisticsData['user_department'] = isset($uDiskData['user_department']) ? $uDiskData['user_department'] : null;
        $statisticsData['province_id'] = isset($uDiskData['province_id']) ? $uDiskData['province_id'] : null;
        $statisticsData['province'] = isset($uDiskData['province']) ? $uDiskData['province'] : null;
        $statisticsData['city_id'] = isset($uDiskData['city_id']) ? $uDiskData['city_id'] : null;
        $statisticsData['city'] = isset($uDiskData['city']) ? $uDiskData['city'] : null;
        $statisticsData['operator_id'] = isset($uDiskData['operator_id']) ? $uDiskData['operator_id'] : null;
        $statisticsData['operator'] = isset($uDiskData['operator']) ? $uDiskData['operator'] : null;
        $statisticsData['date'] = $date;
        $statistics = (new Statistics)->where('uuid', '=', $uuid)
            ->whereBetween('date', [$startDate, $endDate])
            ->first();
        if (!isset($statistics) || empty($statistics)) {
            $statistics = (new Statistics)->create($statisticsData);
        } else {
            $statistics->fill($statisticsData)->save();
        }
        $statisticsId = $statistics->id;
        self::storageReport($statisticsId, $probeResult);
        $statistics->report_count = Report::countReport($statisticsId);
        $statistics->save();
    }

    private static function storageReport($statisticsId, $probeResult)
    {
        $ip = $probeResult['result'];
        $date = $probeResult['dt'];
        $probeType = $probeResult['probeType'];
        if (in_array($probeType, [101, 202,])) {
            $probe_type = 1; // 自有
        } else if (in_array($probeType, [201,])) {
            $probe_type = 2; // 公有
        } else {
            $probe_type = $probeType;
        }
        $ipData = Ip::ipData($ip);
        $reportData = [];
        $reportData['statistics_id'] = $statisticsId;
        $reportData['ip'] = $ip;
        $reportData['operator_id'] = isset($ipData['operator_id']) ? $ipData['operator_id'] : null;
        $reportData['operator'] = isset($ipData['operator']) ? $ipData['operator'] : null;
        $reportData['province_id'] = isset($ipData['province_id']) ? $ipData['province_id'] : null;
        $reportData['province'] = isset($ipData['province']) ? $ipData['province'] : null;
        $reportData['probe_type'] = $probe_type;
        $reportData['date'] = $date;
        $report = (new Report)->where('statistics_id', '=', $statisticsId)
            ->where('ip', '=', $ip)
            ->first();
        if (!isset($report) || empty($report)) {
            $report = (new Report)->create($reportData);
        } else {
            $report->fill($reportData)->save();
        }
    }
}