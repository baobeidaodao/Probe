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

    public static function listDepartment($page = 1, $size = 10)
    {
        $db = (new Department)->join('area as city', 'department.area_id', '=', 'city.id')
            ->join('area as province', 'city.parent_id', '=', 'province.id');
        $count = $db->count();
        $departmentList = $db->select('province.name as province_name', 'city.name as city_name', 'department.id', 'department.area_id', 'department.name')
            ->orderBy('department.id', 'desc')
            ->forPage($page, $size)
            ->get()
            ->toArray();
        $data = [];
        $data['count'] = $count;
        $data['departmentList'] = $departmentList;
        return $data;
    }

    public static function searchDepartment($search = [], $page, $size)
    {
        $db = (new Department)->join('area as city', 'department.area_id', '=', 'city.id')
            ->join('area as province', 'city.parent_id', '=', 'province.id')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['name']) && !empty($search['name'])) {
                    $query->where('department.name', 'like', $search['name']);
                }
                if (isset($search) && isset($search['area_id']) && !empty($search['area_id'])) {
                    $query->where('department.area_id', '=', $search['area_id']);
                }
            });
        $count = $db->count();
        $departmentList = $db->select('province.name as province_name', 'city.name as city_name', 'department.id', 'department.area_id', 'department.name')
            ->orderBy('department.id', 'desc')
            ->forPage($page, $size)
            ->get()
            ->toArray();
        $data = [];
        $data['count'] = $count;
        $data['departmentList'] = $departmentList;
        return $data;
    }
}