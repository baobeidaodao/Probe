<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Department.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 08:52:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'mysql';
    protected $table = 'department';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['area_id', 'name',];

    public static function listDepartment()
    {
        $departmentList = (new Department)->join('area as city', 'department.area_id', '=', 'city.id')
            ->join('area as province', 'city.parent_id', '=', 'province.id')
            ->select('province.name as province_name', 'city.name as city_name', 'department.id', 'department.area_id', 'department.name')
            ->orderBy('department.id', 'desc')
            ->get()
            ->toArray();
        return $departmentList;
    }
}