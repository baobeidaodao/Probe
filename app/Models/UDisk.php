<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: UDisk.php
 * Author  : Li Tao
 * DateTime: 2018-02-21 23:15:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UDisk extends Model
{
    protected $connection = 'mysql';
    protected $table = 'u_disk';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['uuid', 'user_id', 'operator_id',];

    public static function listUDisk($page, $size)
    {
        $db = (new UDisk)
            ->leftJoin('users', 'u_disk.user_id', '=', 'users.id')
            ->leftJoin('operator', 'u_disk.operator_id', '=', 'operator.id');
        $count = $db->count();
        $uDiskList = $db->select('u_disk.*', 'users.id as user_id', 'users.name as user_name', 'operator.id as operator_id', 'operator.name as operator_name')
            ->orderBy('u_disk.id', 'desc')
            ->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['uDiskList'] = $uDiskList;
        return $data;
    }

    public static function searchUDisk($search = [], $page, $size)
    {
        $db = (new UDisk)
            ->leftJoin('users', 'u_disk.user_id', '=', 'users.id')
            ->leftJoin('operator', 'u_disk.operator_id', '=', 'operator.id')
            ->where(function ($query) {
                //$area = Area::areaForUser();
                //$query->whereIn('users.area_id', $area['areaIdList']);
            })
            ->where(function ($query) {
                $userIdList = User::listUserIdForAuth();
                $query->whereIn('u_disk.user_id', $userIdList);
            })
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['uuid']) && !empty($search['uuid'])) {
                    $query->where('u_disk.uuid', 'like', $search['uuid']);
                }
                if (isset($search) && isset($search['user_name']) && !empty($search['user_name'])) {
                    $query->where('users.name', 'like', $search['user_name']);
                }
                if (isset($search) && isset($search['operator_id']) && !empty($search['operator_id'])) {
                    $query->where('u_disk.operator_id', '=', $search['operator_id']);
                }
            });
        $count = $db->count();
        $uDiskList = $db->select('u_disk.*', 'users.id as user_id', 'users.name as user_name', 'operator.id as operator_id', 'operator.name as operator_name')
            ->orderBy('u_disk.id', 'desc')
            ->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['uDiskList'] = $uDiskList;
        return $data;
    }

    /**
     * @author Li Tao
     * @param $uuid
     * @return array
     */
    public static function uDiskData($uuid)
    {
        $uDiskData = (new UDisk)
            ->leftJoin('probeResultVerified', 'probeResultVerified.UDiskUuid', '=', 'u_disk.uuid')
            ->leftJoin('users', 'u_disk.user_id', '=', 'users.id')
            ->leftJoin('operator', 'u_disk.operator_id', '=', 'operator.id')
            ->leftJoin('area as city', 'users.area_id', '=', 'city.id')
            ->leftJoin('area as province', 'city.parent_id', '=', 'province.id')
            ->leftJoin('department', 'users.department_id', '=', 'department.id')
            ->where('u_disk.uuid', '=', $uuid)
            ->select([
                'probeResultVerified.UDiskUuid as u_disk_uuid',
                'u_disk.id as u_disk_id',
                'u_disk.uuid as uuid',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                'department.id as user_department_id',
                'department.name as user_department',
                'province.id as province_id',
                'province.name as province',
                'city.id as city_id',
                'city.name as city',
                'operator.id as operator_id',
                'operator.name as operator',
            ])
            ->distinct()
            ->first();
        if (isset($uDiskData) && !empty($uDiskData)) {
            $uDiskData = $uDiskData->toArray();
        } else {
            $uDiskData = [];
        }
        return $uDiskData;
    }

}