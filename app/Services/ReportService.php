<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: ReportService.php
 * Author  : Li Tao
 * DateTime: 2018-03-12 03:00:00
 */

namespace App\Services;


use App\Models\Area;
use App\Models\Report;

class ReportService
{
    public static function summaryReportForProvinceList($search = [])
    {
        $reportData = [];
        $reportList = [];
        $summary = [];
        $provinceList = Area::listProvince();
        foreach ($provinceList as $province) {
            $provinceId = $province['id'];
            $reportList[$provinceId]['province_id'] = $province['id'];
            $reportList[$provinceId]['province'] = $province['name'];
            $reportList[$provinceId]['report_list'] = [];
            $reportList[$provinceId]['report_count'] = 0;
            $summary['report_count'] = 0;
        }
        $reportArray = Report::listReportForProvince($search);
        foreach ($reportArray as $report) {
            $provinceId = isset($report['report_province_id']) && !empty($report['report_province_id']) ? $report['report_province_id'] : 0;
            $reportList[$provinceId]['report_list'][] = $report;
            $reportList[$provinceId]['report_count'] += 1;
            $summary['report_count'] += 1;
        }
        $reportData['reportList'] = $reportList;
        $reportData['summary'] = $summary;
        return $reportData;
    }
}