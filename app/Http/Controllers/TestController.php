<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: TestController.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 04:35:00
 */

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Department;
use App\Models\ReportConfig;
use App\Models\Statistics;
use App\Models\UDisk;
use App\Models\User;
use App\Services\AdminService;
use App\Services\ReportService;
use App\Services\StatisticsService;
use App\Services\UserService;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    public static function index()
    {
        //AdminService::listAreaMap();
        //UDiskService::listUDisk();
        //Department::listDepartment();
        //$ip = '2.255.255.255';
        //$long = ip2long($ip);
        //dd($long);
        //$publicTypeArray = config('probe.probe_type.1');
        //$data = UserService::listAreaMapForUser();
        //$data = Area::area((new User)->find(13));
        //dd($data);
        //StatisticsService::storage();
        //StatisticsService::storageOfDate('2018-02-20', '2018-02-24');
        //$uDiskData = UDisk::uDiskData();
        //dd($uDiskData);
        //$data = Statistics::with('report')->get()->toArray();
        //$data = UDisk::countUDiskForArea(440000);
        //$data = Statistics::countReportUDiskForArea(440000);
        //$data = Statistics::countReportForArea(440000);
        //$data = StatisticsService::summaryStatisticsForGroup();
        //$data = Statistics::listStatisticsForUserList();
        //$data = StatisticsService::summaryStatisticsForCity();
        //$data = ReportService::summaryReportForProvinceList();
//        $cellData = [
//            ['学号', '姓名', '成绩'],
//            ['10001', 'AAAAA', '99'],
//            ['10002', 'BBBBB', '92'],
//            ['10003', 'CCCCC', '95'],
//            ['10004', 'DDDDD', '89'],
//            ['10005', 'EEEEE', '96'],
//        ];
//        Excel::create('aaaa', function ($excel) use ($cellData) {
//            $excel->sheet('score', function ($sheet) use ($cellData) {
//                $sheet->rows($cellData);
//            });
//        })->export('xls');
        $data = ReportConfig::operatorIdLevel();
        dd($data);
        return view('test');
    }
}