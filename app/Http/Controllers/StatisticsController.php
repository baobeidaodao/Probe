<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: StatisticsController.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 19:14:00
 */

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Operator;
use App\Models\Statistics;
use App\Models\UserLevel;
use App\Services\AdminService;
use App\Services\AppService;
use App\Services\StatisticsService;
use Auth;
use Illuminate\Http\Request;

class StatisticsController extends Controller
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
            return redirect('admin/statistics/group');
        }
        $page = isset($request->page) ? $request->page : 1;
        $size = 10;
        $search = [
            'uuid' => isset($request->uuid) ? $request->uuid : '',
            'province_id' => isset($request->province_id) ? $request->province_id : 0,
            'city_id' => isset($request->city_id) ? $request->city_id : 0,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
            'start_date' => isset($request->start_date) ? $request->start_date . ' 00:00:00' : '',
            'end_date' => isset($request->end_date) ? $request->end_date . ' 23.59.59' : '',
        ];
        // $statisticsListData = Statistics::listStatistics($search, $page, $size);
        $statisticsListData = Statistics::listStatisticsForUDisk($search, $page, $size);
        $search['start_date'] = isset($search['start_date']) && !empty($search['start_date']) ? date('Y-m-d', strtotime($search['start_date'])) : '';
        $search['end_date'] = isset($search['end_date']) && !empty($search['end_date']) ? date('Y-m-d', strtotime($search['end_date'])) : '';
        $pagination = AppService::calculatePagination($page, $size, $statisticsListData['count']);
        //$areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['statisticsList'] = $statisticsListData['statisticsList'];
        $data['pagination'] = $pagination;
        $data['operatorList'] = $operatorList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['form'] = 'search';
        $data['active'] = 'statistics';
        return view('admin.statistics.index', $data);
    }

    public static function summary(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $size = 10;
        $search = [
            'uuid' => isset($request->uuid) ? $request->uuid : '',
            'province_id' => isset($request->province_id) ? $request->province_id : 0,
            'city_id' => isset($request->city_id) ? $request->city_id : 0,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
            'start_date' => isset($request->start_date) ? $request->start_date . ' 00:00:00' : '',
            'end_date' => isset($request->end_date) ? $request->end_date . ' 23.59.59' : '',
        ];
        $statisticsListData = Statistics::summaryStatistics($search, $page, $size);
        $search['start_date'] = isset($search['start_date']) && !empty($search['start_date']) ? date('Y-m-d', strtotime($search['start_date'])) : '';
        $search['end_date'] = isset($search['end_date']) && !empty($search['end_date']) ? date('Y-m-d', strtotime($search['end_date'])) : '';
        $pagination = AppService::calculatePagination($page, $size, $statisticsListData['count']);
        //$areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['statisticsList'] = $statisticsListData['statisticsList'];
        $data['pagination'] = $pagination;
        $data['operatorList'] = $operatorList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['form'] = 'summary';
        $data['active'] = 'statistics';
        return view('admin.statistics.index', $data);
    }

    public static function group(Request $request)
    {
        $startDate = isset($request->start_date) ? $request->start_date . ' 00:00:00' : date('Y-m-d 00:00:00', strtotime('-30 day'));
        $endDate = isset($request->end_date) ? $request->end_date . ' 23.59.59' : date('Y-m-d 23.59.59', strtotime('-1 day'));
        $search = [
            'province_id' => isset($request->province_id) ? $request->province_id : 0,
            'city_id' => isset($request->city_id) ? $request->city_id : 0,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        // $statisticsListData = Statistics::listStatistics($search, $page, $size);
        $statisticsData = StatisticsService::summaryStatisticsForGroup($search);
        $search['start_date'] = date('Y-m-d', strtotime($startDate));
        $search['end_date'] = date('Y-m-d', strtotime($endDate));
        //$areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['statisticsList'] = $statisticsData['statisticsList'];
        $data['summary'] = $statisticsData['summary'];
        $data['operatorList'] = $operatorList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['form'] = 'search';
        $data['active'] = 'statistics';
        return view('admin.statistics.group', $data);
    }

    public static function province(Request $request)
    {
        if (Auth::user()->level == UserLevel::LEVEL_PROVINCIAL_MANAGER) {
            $provinceId = Auth::user()->province_id;
        } else {
            $provinceId = 0;
        }
        $startDate = isset($request->start_date) ? $request->start_date . ' 00:00:00' : date('Y-m-d 00:00:00', strtotime('-30 day'));
        $endDate = isset($request->end_date) ? $request->end_date . ' 23.59.59' : date('Y-m-d 23.59.59', strtotime('-1 day'));
        $search = [
            'province_id' => isset($request->province_id) ? $request->province_id : $provinceId,
            'city_id' => isset($request->city_id) ? $request->city_id : 0,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        // $statisticsListData = Statistics::listStatistics($search, $page, $size);
        $statisticsData = StatisticsService::summaryStatisticsForProvince($search);
        $search['start_date'] = date('Y-m-d', strtotime($startDate));
        $search['end_date'] = date('Y-m-d', strtotime($endDate));
        //$areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['statisticsList'] = $statisticsData['statisticsList'];
        $data['summary'] = $statisticsData['summary'];
        $data['operatorList'] = $operatorList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['form'] = 'search';
        $data['active'] = 'statistics';
        return view('admin.statistics.province', $data);
    }

    public static function city(Request $request)
    {
        if (Auth::user()->level == UserLevel::LEVEL_PROVINCIAL_MANAGER) {
            $provinceId = Auth::user()->province_id;
        } else {
            $provinceId = 0;
        }
        if (Auth::user()->level == UserLevel::LEVEL_MUNICIPAL_MANAGER) {
            $cityId = Auth::user()->city_id;
        } else {
            $cityId = 0;
        }
        $startDate = isset($request->start_date) ? $request->start_date . ' 00:00:00' : date('Y-m-d 00:00:00', strtotime('-30 day'));
        $endDate = isset($request->end_date) ? $request->end_date . ' 23.59.59' : date('Y-m-d 23.59.59', strtotime('-1 day'));
        $search = [
            'province_id' => isset($request->province_id) ? $request->province_id : $provinceId,
            'city_id' => isset($request->city_id) ? $request->city_id : $cityId,
            'operator_id' => isset($request->operator_id) ? $request->operator_id : 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        // $statisticsListData = Statistics::listStatistics($search, $page, $size);
        $statisticsData = StatisticsService::summaryStatisticsForCity($search);//dd($statisticsData);
        $search['start_date'] = date('Y-m-d', strtotime($startDate));
        $search['end_date'] = date('Y-m-d', strtotime($endDate));
        //$areaMap = AdminService::listAreaMap();
        $areaMap = AdminService::listAreaMapForUser();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_2)->get()->toArray();
        $tips = StatisticsService::statisticsTips($search);
        $data = [];
        $data['statisticsList'] = $statisticsData['statisticsList'];
        $data['summary'] = $statisticsData['summary'];
        $data['operatorList'] = $operatorList;
        $data['areaMap'] = $areaMap;
        $data['search'] = $search;
        $data['tips'] = $tips;
        $data['form'] = 'search';
        $data['active'] = 'statistics';
        return view('admin.statistics.city', $data);
    }

    public static function user(Request $request)
    {
        dd('u');
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