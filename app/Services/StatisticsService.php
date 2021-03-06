<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: StatisticsService.php
 * Author  : Li Tao
 * DateTime: 2018-02-26 05:51:00
 */

namespace App\Services;


use App\Models\Area;
use App\Models\Ip;
use App\Models\ProbeResultVerified;
use App\Models\Report;
use App\Models\Statistics;
use App\Models\UDisk;
use App\Models\User;

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
        $endDateTime = $date . ' 23:59:59';
        $probeResultVerifiedList = (new UDisk)
            ->leftJoin('probeResultVerified', function ($join) use ($startDateTime, $endDateTime) {
                $join->on('probeResultVerified.UDiskUuid', '=', 'u_disk.uuid')
                    ->whereBetween('probeResultVerified.dt', [$startDateTime, $endDateTime]);
            })
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereNull('probeResultVerified.dt')
                    ->orWhereBetween('probeResultVerified.dt', [$startDateTime, $endDateTime]);
            })
            ->orderBy('probeResultVerified.dt', 'asc')
            ->select([
                'u_disk.id as u_disk_id',
                'u_disk.uuid as uuid',
                'probeResultVerified.*',
            ])
            ->get()
            ->toArray();
        $probeResultArray = self::filterProbeResult($probeResultVerifiedList);
        foreach ($probeResultArray as $probeResult) {
            if (!isset($probeResult['dt']) || empty($probeResult['dt'])) {
                $probeResult['dt'] = $date . ' 00:00:00';
            }
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
            } else {
                $key = $probeResult['uuid'];
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
        $uuid = $probeResult['uuid'];
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
        $statisticsData['date'] = date('Y-m-d 00:00:00', strtotime($date));
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
        if (!isset($ip) || empty($ip)) {
            return;
        }
        $date = $probeResult['dt'];
        $probeType = $probeResult['probeType'];
        $privateTypeArray = config('probe.probe_type.1');
        $publicTypeArray = config('probe.probe_type.2');
        if (in_array($probeType, $privateTypeArray)) {
            $probe_type = 1; // 自有
        } else if (in_array($probeType, $publicTypeArray)) {
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

    /**
     * @author Li Tao
     * @param $search
     * @return array
     */
    public static function statisticsTips($search)
    {
        $statisticsList = (new Statistics)
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['uuid']) && !empty($search['uuid'])) {
                    $query->where('statistics.uuid', '=', $search['uuid']);
                }
                if (isset($search) && isset($search['province_id']) && !empty($search['province_id'])) {
                    $query->where('statistics.province_id', '=', $search['province_id']);
                }
                if (isset($search) && isset($search['city_id']) && !empty($search['city_id'])) {
                    //$query->where('statistics.city_id', '=', $search['city_id']);
                }
                if (isset($search) && isset($search['operator_id']) && !empty($search['operator_id'])) {
                    $query->where('statistics.operator_id', '=', $search['operator_id']);
                }
                if (isset($search) && isset($search['start_date']) && !empty($search['start_date'])) {
                    $query->where('statistics.date', '>=', $search['start_date']);
                }
                if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
                    $query->where('statistics.date', '<=', $search['end_date']);
                }
            })
            ->get()
            ->toArray();
        $province = [];
        $cityList = [];
        $province['number'] = 0;
        foreach ($statisticsList as $statistics) {
            if (isset($statistics['province_id']) && !empty($statistics['province_id'])) {
                $province['id'] = $statistics['province_id'];
                $province['name'] = $statistics['province'];
                $province['number'] = $province['number'] + $statistics['report_count'];
                $cityId = $statistics['city_id'];
                if (isset($cityList[$cityId]) && !empty($cityList[$cityId])) {
                    $cityList[$cityId]['number'] = $cityList[$cityId]['number'] + $statistics['report_count'];
                } else {
                    $cityList[$cityId]['id'] = $statistics['city_id'];
                    $cityList[$cityId]['name'] = $statistics['city'];
                    $cityList[$cityId]['number'] = $statistics['report_count'];
                }
            }
        }
        $tips['province'] = $province;
        $tips['cityList'] = $cityList;
        return $tips;
    }

    public static function summaryStatisticsForGroup($search = [])
    {
        $statisticsData = [];
        $statisticsList = [];
        $provinceList = Area::listProvince();
        $summary = [];
        foreach ($provinceList as $province) {
            $provinceId = $province['id'];
            $statistics = self::listStatisticsForProvince($provinceId, $search);
            $statistics['provinceName'] = $province['name'];
            $statisticsList[] = $statistics;
            $summary['installUDiskCount'] = (isset($summary['installUDiskCount']) ? $summary['installUDiskCount'] : 0) + $statistics['installUDiskCount'];
            $summary['reportUDiskCount'] = (isset($summary['reportUDiskCount']) ? $summary['reportUDiskCount'] : 0) + $statistics['reportUDiskCount'];
            $summary['reportCount'] = (isset($summary['reportCount']) ? $summary['reportCount'] : 0) + $statistics['reportCount'];
        }
        $statisticsData['statisticsList'] = $statisticsList;
        $statisticsData['summary'] = $summary;
        return $statisticsData;
    }

    public static function listStatisticsForProvince($provinceId, $search = [])
    {
        $installUDiskCount = UDisk::countInstallUDiskForArea($provinceId, Area::LEVEL_PROVINCE, $search);
        $reportUDiskCount = Statistics::countReportUDiskForArea($provinceId, Area::LEVEL_PROVINCE, $search);
        $reportCount = Statistics::countReportForArea($provinceId, Area::LEVEL_PROVINCE, $search);
        $statistics = [];
        $statistics['provinceId'] = $provinceId;
        $statistics['installUDiskCount'] = $installUDiskCount;
        $statistics['reportUDiskCount'] = $reportUDiskCount;
        $statistics['reportCount'] = $reportCount;
        return $statistics;
    }

    public static function summaryStatisticsForProvince($search = [])
    {
        $statisticsData = [];
        $statisticsList = [];
        $provinceId = $search['province_id'];
        $cityList = Area::listCityOfProvince($provinceId);
        $summary = [];
        foreach ($cityList as $city) {
            $cityId = $city['id'];
            $statistics = self::listStatisticsForCity($cityId, $search);
            $statistics['cityName'] = $city['name'];
            $statisticsList[] = $statistics;
            $summary['installUDiskCount'] = (isset($summary['installUDiskCount']) ? $summary['installUDiskCount'] : 0) + $statistics['installUDiskCount'];
            $summary['reportUDiskCount'] = (isset($summary['reportUDiskCount']) ? $summary['reportUDiskCount'] : 0) + $statistics['reportUDiskCount'];
            $summary['reportCount'] = (isset($summary['reportCount']) ? $summary['reportCount'] : 0) + $statistics['reportCount'];
        }
        $statisticsData['statisticsList'] = $statisticsList;
        $statisticsData['summary'] = $summary;
        return $statisticsData;
    }

    public static function listStatisticsForCity($cityId, $search = [])
    {
        $installUDiskCount = UDisk::countInstallUDiskForArea($cityId, Area::LEVEL_CITY, $search);
        $reportUDiskCount = Statistics::countReportUDiskForArea($cityId, Area::LEVEL_CITY, $search);
        $reportCount = Statistics::countReportForArea($cityId, Area::LEVEL_CITY, $search);
        $statistics = [];
        $statistics['cityId'] = $cityId;
        $statistics['installUDiskCount'] = $installUDiskCount;
        $statistics['reportUDiskCount'] = $reportUDiskCount;
        $statistics['reportCount'] = $reportCount;
        return $statistics;
    }

    public static function summaryStatisticsForCity($search = [])
    {
        // $cityId = $search['city_id'];
        // $userList = User::listUserForCity($cityId);
        $statisticsData = [];
        $statisticsList = [];
        $statisticsSummary = [];
        $statisticsArray = Statistics::listStatisticsForUserList($search);
        //dd($statisticsList);
        foreach ($statisticsArray as $statistics) {
            $userId = $statistics['user_id'];
            if (!isset($statisticsList[$userId]) || empty($statisticsList[$userId])) {
                $summary = [];
                $summary['user_id'] = $statistics['user_id'];
                $summary['user_name'] = $statistics['user_name'];
                $summary['user_phone'] = $statistics['user_phone'];
                $summary['user_email'] = $statistics['user_email'];
                $summary['user_department_id'] = $statistics['user_department_id'];
                $summary['user_department'] = $statistics['user_department'];
                $summary['province_id'] = $statistics['province_id'];
                $summary['province'] = $statistics['province'];
                $summary['city_id'] = $statistics['city_id'];
                $summary['city'] = $statistics['city'];
                $summary['operator_id'] = $statistics['operator_id'];
                $summary['operator'] = $statistics['operator'];
                $summary['u_disk_list'][] = $statistics['uuid'];
                $summary['u_disk_count'] = 1;
                // $summary['report_count'] = $statistics['report_count'];
                $summary['report_count'] = 1;
                $statisticsList[$userId]['summary'] = $summary;
            } else {
                if (!in_array($statistics['uuid'], $statisticsList[$userId]['summary']['u_disk_list'])) {
                    $statisticsList[$userId]['summary']['u_disk_list'][] = $statistics['uuid'];
                    $statisticsList[$userId]['summary']['u_disk_count'] += 1;
                }
                // $statisticsData[$userId]['summary']['report_count'] += $statistics['report_count'];
                $statisticsList[$userId]['summary']['report_count'] += 1;
            }
            $report = [];
            $report['uuid'] = $statistics['uuid'];
            $report['ip'] = $statistics['ip'];
            $report['report_operator_id'] = $statistics['report_operator_id'];
            $report['report_operator'] = $statistics['report_operator'];
            $report['report_province_id'] = $statistics['report_province_id'];
            $report['report_province'] = $statistics['report_province'];
            $report['probe_type'] = $statistics['probe_type'];
            $report['report_date'] = $statistics['report_date'];
            $statisticsList[$userId]['report_list'][] = $report;
        }
        $statisticsSummary['user_count'] = count($statisticsList);
        $statisticsSummary['u_disk_count'] = 0;
        $statisticsSummary['report_count'] = 0;
        foreach ($statisticsList as $statistics) {
            $statisticsSummary['u_disk_count'] += $statistics['summary']['u_disk_count'];
            $statisticsSummary['report_count'] += $statistics['summary']['report_count'];
        }
        $statisticsData['statisticsList'] = $statisticsList;
        $statisticsData['summary'] = $statisticsSummary;
        return $statisticsData;
    }
}