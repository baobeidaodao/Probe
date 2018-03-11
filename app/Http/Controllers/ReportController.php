<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: ReportController.php
 * Author  : Li Tao
 * DateTime: 2018-02-23 10:57:00
 */

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Operator;
use App\Models\Report;
use App\Models\UserLevel;
use App\Services\AdminService;
use App\Services\AppService;
use App\Services\ReportService;
use App\Services\StatisticsService;
use Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public static function index(Request $request)
    {
        if (Auth::user()->level <= UserLevel::LEVEL_GROUP_MANAGER) {
            return redirect('admin/report/group');
        }
        $page = isset($request->page) ? $request->page : 1;
        $size = 10;
        $search = [
            'uuid' => isset($request->uuid) ? $request->uuid : '',
            'ip' => isset($request->ip) ? $request->ip : '',
            'province_id' => isset($request->province_id) ? $request->province_id : null,
            'city_id' => isset($request->city_id) ? $request->city_id : null,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : null,
            'start_date' => isset($request->start_date) ? $request->start_date . ' 00:00:00' : '',
            'end_date' => isset($request->end_date) ? $request->end_date . ' 23.59.59' : '',
        ];
        $reportListData = Report::listReport($search, $page, $size);
        // $reportListData = Report::listReportForUDisk($search, $page, $size);
        $search['start_date'] = isset($search['start_date']) && !empty($search['start_date']) ? date('Y-m-d', strtotime($search['start_date'])) : '';
        $search['end_date'] = isset($search['end_date']) && !empty($search['end_date']) ? date('Y-m-d', strtotime($search['end_date'])) : '';
        $pagination = AppService::calculatePagination($page, $size, $reportListData['count']);
        // $areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['reportList'] = $reportListData['reportList'];
        $data['pagination'] = $pagination;
        $data['operatorList'] = $operatorList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['active'] = 'report';
        return view('admin.report.index', $data);
    }

    public static function group(Request $request)
    {
        $firstDay = date('Y-m-01 00:00:00', strtotime(date('Y', time()) . '-' . (date('m', time()) - 1) . '-01'));
        $lastDay = date('Y-m-d 23.59.59', strtotime("$firstDay +1 month -1 day"));
        //$startDate = isset($request->start_date) ? $request->start_date . ' 00:00:00' : date('Y-m-d 00:00:00', strtotime('-30 day'));
        //$endDate = isset($request->end_date) ? $request->end_date . ' 23.59.59' : date('Y-m-d 23.59.59', strtotime('-1 day'));
        $startDate = isset($request->start_date) ? $request->start_date . ' 00:00:00' : $firstDay;
        $endDate = isset($request->end_date) ? $request->end_date . ' 23.59.59' : $lastDay;
        $search = [
            'probe_type' => isset($request->probe_type) ? $request->probe_type : 0,
            'ip' => isset($request->ip) ? $request->ip : '',
            'report_province_id' => isset($request->report_province_id) ? $request->report_province_id : 0,
            'report_operator_id' => isset($request->report_operator_id) ? $request->report_operator_id : 0,
            'province_id' => isset($request->province_id) ? $request->province_id : 0,
            'city_id' => isset($request->city_id) ? $request->city_id : 0,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        // $statisticsListData = Statistics::listStatistics($search, $page, $size);
        $reportData = ReportService::summaryReportForProvinceList($search);
        $search['start_date'] = date('Y-m-d', strtotime($startDate));
        $search['end_date'] = date('Y-m-d', strtotime($endDate));
        //$areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $reportOperatorList = (new Operator())->where('level', '=', Operator::LEVEL_1)->get()->toArray();
        $provinceList = Area::listProvince();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['reportList'] = $reportData['reportList'];
        $data['summary'] = $reportData['summary'];
        $data['operatorList'] = $operatorList;
        $data['reportOperatorList'] = $reportOperatorList;
        $data['provinceList'] = $provinceList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['form'] = 'search';
        $data['active'] = 'report';
        return view('admin.report.summary', $data);
    }

    public static function province(Request $request)
    {
        $firstDay = date('Y-m-01 00:00:00', strtotime(date('Y', time()) . '-' . (date('m', time()) - 1) . '-01'));
        $lastDay = date('Y-m-d 23.59.59', strtotime("$firstDay +1 month -1 day"));
        //$startDate = isset($request->start_date) ? $request->start_date . ' 00:00:00' : date('Y-m-d 00:00:00', strtotime('-30 day'));
        //$endDate = isset($request->end_date) ? $request->end_date . ' 23.59.59' : date('Y-m-d 23.59.59', strtotime('-1 day'));
        $startDate = isset($request->start_date) ? $request->start_date . ' 00:00:00' : $firstDay;
        $endDate = isset($request->end_date) ? $request->end_date . ' 23.59.59' : $lastDay;
        $search = [
            'probe_type' => isset($request->probe_type) ? $request->probe_type : 0,
            'ip' => isset($request->ip) ? $request->ip : '',
            'report_province_id' => isset($request->report_province_id) ? $request->report_province_id : 0,
            'report_operator_id' => isset($request->report_operator_id) ? $request->report_operator_id : 0,
            'province_id' => isset($request->province_id) ? $request->province_id : 0,
            'city_id' => isset($request->city_id) ? $request->city_id : 0,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        // $statisticsListData = Statistics::listStatistics($search, $page, $size);
        $reportData = ReportService::summaryReportForProvinceList($search);
        $search['start_date'] = date('Y-m-d', strtotime($startDate));
        $search['end_date'] = date('Y-m-d', strtotime($endDate));
        //$areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $reportOperatorList = (new Operator())->where('level', '=', Operator::LEVEL_1)->get()->toArray();
        $provinceList = Area::listProvince();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['reportList'] = $reportData['reportList'];
        $data['summary'] = $reportData['summary'];
        $data['operatorList'] = $operatorList;
        $data['reportOperatorList'] = $reportOperatorList;
        $data['provinceList'] = $provinceList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['form'] = 'search';
        $data['active'] = 'report';
        return view('admin.report.province', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}