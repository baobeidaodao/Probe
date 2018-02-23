<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Ip.php
 * Author  : Li Tao
 * DateTime: 2018-02-23 09:56:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $connection = 'mysql';
    protected $table = 'ip';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = ['ip', 'mask', 'type', 'operator_id', 'area_id',];

    public static function listIp()
    {
        $ipList = (new Ip)->leftJoin('operator', 'ip.operator_id', '=', 'operator.id')
            ->leftJoin('area', 'ip.area_id', '=', 'area.id')
            ->select('ip.*', 'operator.name as operator_name', 'area.name as area_name')
            ->get()
            ->toArray();
        return $ipList;
    }
}