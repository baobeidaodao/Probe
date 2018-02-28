<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: IpController.php
 * Author  : Li Tao
 * DateTime: 2018-02-23 08:17:00
 */

namespace App\Http\Controllers;

use App\Models\ActionLog;
use App\Models\Area;
use App\Models\Ip;
use App\Models\Operator;
use App\Services\AdminService;
use App\Services\AppService;
use Illuminate\Http\Request;

class IpController extends Controller
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
            'ip' => isset($request->ip) ? $request->ip : '',
            'operator_id' => isset($request->operator_id) ? $request->operator_id : null,
            'area_id' => isset($request->province_id) ? $request->province_id : null,
        ];
        // $ipListData = Ip::listIp($page, $size);
        $ipListData = Ip::searchIp($search, $page, $size);
        $pagination = AppService::calculatePagination($page, $size, $ipListData['count']);
        $areaMap = AdminService::listAreaMap();
        $cityList = Area::listCity();
        $provinceList = Area::listProvince();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_1)->get()->toArray();
        $data = [];
        $data['ipList'] = $ipListData['ipList'];
        $data['pagination'] = $pagination;
        $data['search'] = $search;
        $data['areaMap'] = $areaMap;
        $data['cityList'] = $cityList;
        $data['provinceList'] = $provinceList;
        $data['operatorList'] = $operatorList;
        $data['active'] = 'ip';
        return view('admin.ip.index', $data);
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
        $ip = (new Ip())->create([
            'start_ip' => $request->start_ip,
            'start_value' => ip2long($request->start_ip),
            'end_ip' => $request->end_ip,
            'end_value' => ip2long($request->end_ip),
            'operator_id' => $request->operator_id,
            'area_id' => $request->province_id,
        ]);
        ActionLog::log(ActionLog::ACTION_CREATE_IP, isset($ip->start_ip) && isset($ip->end_ip) ? $ip->start_ip . ' - ' . $ip->end_ip : '');
        return redirect('admin/ip');
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
        $ip = (new Ip())->findOrFail($id);
        $ip->fill([
            'start_ip' => $request->start_ip,
            'start_value' => ip2long($request->start_ip),
            'end_ip' => $request->end_ip,
            'end_value' => ip2long($request->end_ip),
            'operator_id' => $request->operator_id,
            'area_id' => $request->province_id,
        ])->save();
        ActionLog::log(ActionLog::ACTION_EDIT_IP, isset($ip->start_ip) && isset($ip->end_ip) ? $ip->start_ip . ' - ' . $ip->end_ip : '');
        return redirect('admin/ip');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ip = (new Ip())->findOrFail($id);
        try {
            $ip->delete();
            ActionLog::log(ActionLog::ACTION_DELETE_IP, isset($ip->start_ip) && isset($ip->end_ip) ? $ip->start_ip . ' - ' . $ip->end_ip : '');
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect('admin/ip');
    }

    public static function search($page = 1, Request $request)
    {
        $size = 10;
        $search = [
            'ip' => isset($request->ip) ? $request->ip : '',
            'operator_id' => isset($request->operator_id) ? $request->operator_id : null,
            'area_id' => isset($request->province_id) ? $request->province_id : null,
        ];
        $ipListData = Ip::searchIp($search, $page, $size);
        $pagination = AppService::calculatePagination($page, $size, $ipListData['count']);
        $areaMap = AdminService::listAreaMap();
        $cityList = Area::listCity();
        $provinceList = Area::listProvince();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_1)->get()->toArray();
        $data = [];
        $data['ipList'] = $ipListData['ipList'];
        $data['search'] = $search;
        $data['pagination'] = $pagination;
        $data['areaMap'] = $areaMap;
        $data['cityList'] = $cityList;
        $data['provinceList'] = $provinceList;
        $data['operatorList'] = $operatorList;
        $data['active'] = 'ip';
        return view('admin.ip.index', $data);
    }
}