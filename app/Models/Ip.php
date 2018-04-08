<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Ip.php
 * Author  : Li Tao
 * DateTime: 2018-02-23 09:56:00
 */

namespace App\Models;

use App\Services\AppService;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $connection = 'mysql';
    protected $table = 'ip';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['start_ip', 'start_value', 'end_ip', 'end_value', 'operator_id', 'area_id',];

    /**
     * 列出 ip
     * @author Li Tao
     * @param int $page
     * @param int $size
     * @return array
     */
    public static function listIp($page = 1, $size = 10)
    {
        $db = (new Ip)->leftJoin('operator', 'ip.operator_id', '=', 'operator.id')
            ->leftJoin('area', 'ip.area_id', '=', 'area.id');
        $count = $db->count();
        $ipList = $db->select('ip.*', 'operator.name as operator_name', 'area.name as area_name')
            ->orderBy('ip.id', 'desc')
            ->forPage($page, $size)
            ->get()
            ->toArray();
        $data = [];
        $data['count'] = $count;
        $data['ipList'] = $ipList;
        return $data;
    }

    /**
     * 查询 ip
     * @author Li Tao
     * @param array $search
     * @param int $page
     * @param int $size
     * @return array
     */
    public static function searchIp($search = [], $page = 1, $size = 10)
    {
        $db = (new Ip)->leftJoin('operator', 'ip.operator_id', '=', 'operator.id')
            ->leftJoin('area', 'ip.area_id', '=', 'area.id')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['ip']) && !empty($search['ip'])) {
                    // $ipValue = ip2long($search['ip']);
                    // $ipValue = printf("%u", ip2long($search['ip']));
                    // $ipValue = bindec(decbin(ip2long($search['ip'])));
                    $ipValue = AppService::ipToLong($search['ip']); // var_dump($ipValue);die();
                    $ipValue = $ipValue . ''; // var_dump($ipValue);die();
                    $query->where('ip.start_value', '<=', $ipValue)
                        ->where('ip.end_value', '>=', $ipValue);
                }
                if (isset($search) && isset($search['operator_id']) && !empty($search['operator_id'])) {
                    $query->where('ip.operator_id', '=', $search['operator_id']);
                }
                if (isset($search) && isset($search['area_id']) && !empty($search['area_id'])) {
                    $query->where('ip.area_id', '=', $search['area_id']);
                }
            });
        $count = $db->count();
        $ipList = $db->select('ip.*', 'operator.name as operator_name', 'area.name as area_name')
            ->orderBy('ip.id', 'desc')
            ->forPage($page, $size)
            ->get()
            ->toArray();
        $data = [];
        $data['count'] = $count;
        $data['ipList'] = $ipList;
        return $data;
    }

    public static function ipData($ip)
    {
        $ipValue = ip2long($ip);
        $ipData = (new Ip)->leftJoin('operator', 'ip.operator_id', '=', 'operator.id')
            ->leftJoin('area as province', 'ip.area_id', '=', 'province.id')
            ->where('ip.start_value', '<=', $ipValue)
            ->where('ip.end_value', '>=', $ipValue)
            ->select([
                'operator.id as operator_id',
                'operator.name as operator',
                'province.id as province_id',
                'province.name as province',
            ])
            ->first();
        if (isset($ipData) && !empty($ipData)) {
            $ipData = $ipData->toArray();
        } else {
            $ipData = [];
        }
        return $ipData;
    }
}