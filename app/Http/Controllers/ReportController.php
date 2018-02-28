<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: ReportController.php
 * Author  : Li Tao
 * DateTime: 2018-02-23 10:57:00
 */

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Report;
use App\Services\AdminService;
use App\Services\AppService;
use App\Services\StatisticsService;
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
        $areaMap = AdminService::listAreaMap();
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