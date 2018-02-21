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
    public $timestamps = false;
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

}