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
use Illuminate\Http\Request;

class IpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function index()
    {
        $ipList = Ip::listIp();
        $areaMap = AdminService::listAreaMap();
        $cityList = Area::listCity();
        $provinceList = Area::listProvince();
        $operatorList = (new Operator())->where('level', '=', Operator::LEVEL_1)->get()->toArray();
        $data = [];
        $data['ipList'] = $ipList;
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
            'ip' => $request->ip,
            'mask' => $request->mask,
            'type' => $request->type,
            'operator_id' => $request->operator_id,
            'area_id' => $request->province_id,
        ]);
        ActionLog::log(ActionLog::ACTION_CREATE_IP, isset($ip->ip) ? $ip->ip : '');
        return redirect()->back();
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
            'ip' => $request->ip,
            'mask' => $request->mask,
            'type' => $request->type,
            'operator_id' => $request->operator_id,
            'area_id' => $request->province_id,
        ])->save();
        ActionLog::log(ActionLog::ACTION_EDIT_IP, isset($ip->ip) ? $ip->ip : '');
        return redirect()->back();
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
            ActionLog::log(ActionLog::ACTION_DELETE_IP, isset($ip->ip) ? $ip->ip : '');
        } catch (\Exception $e) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}