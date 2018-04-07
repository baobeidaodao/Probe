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
use App\Models\UserLevel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        if (Auth::user()->level <= UserLevel::LEVEL_GROUP_MANAGER) {
            $summary['report_count'] = Report::countReportForGroup($search);
        }
        $reportData['reportList'] = $reportList;
        $reportData['summary'] = $summary;
        return $reportData;
    }

    public static function exportReportData($provinceId, $reportList = [], $search = [])
    {
        $head = [];
        $head[] = [
            'IP',
            '所属省',
            '所属运营商',
            '测试时间',
            'U盾省',
            'U盾市',
            'U盾运营商',
            '类型',
        ];
        $date = date('Y-m', strtotime($search['start_date']));
        if ($provinceId == 0) {
            $provinceName = '所有省';
            $fileName = $provinceName . '-' . $date;
            Excel::create($fileName, function ($excel) use ($head, $reportList) {
                foreach ($reportList as $report) {
                    $list = $report['report_list'];
                    if (!isset($list) || empty($list)) {
                        continue;
                    }
                    $cellData = [];
                    $provinceName = '';
                    foreach ($list as $item) {
                        $provinceName = $item['report_province'];
                        $cellData[] = [
                            $item['ip'],
                            $item['report_province'],
                            $item['report_operator'],
                            $item['report_date'],
                            $item['province'],
                            $item['city'],
                            $item['operator'],
                            $item['probe_type'] == 1 ? '自有' : '公有',
                        ];
                    }
                    $cellData = array_merge($head, $cellData);
                    $excel->sheet($provinceName, function ($sheet) use ($cellData) {
                        $sheet->rows($cellData);
                    });
                }
            })->export('xls');
        } else {
            $provinceName = '';
            $cellData = [];
            foreach ($reportList as $report) {
                if (isset($report['province_id']) && $report['province_id'] == $provinceId) {
                    $list = $report['report_list'];
                    foreach ($list as $item) {
                        $provinceName = $item['report_province'];
                        $cellData[] = [
                            $item['ip'],
                            $item['report_province'],
                            $item['report_operator'],
                            $item['report_date'],
                            $item['province'],
                            $item['city'],
                            $item['operator'],
                            $item['probe_type'] == 1 ? '自有' : '公有',
                        ];
                    }
                }
            }
            $fileName = $provinceName . '-' . $date;
            $cellData = array_merge($head, $cellData);
            Excel::create($fileName, function ($excel) use ($cellData, $provinceName) {
                $excel->sheet($provinceName, function ($sheet) use ($cellData) {
                    $sheet->rows($cellData);
                });
            })->export('xls');
        }
    }

}