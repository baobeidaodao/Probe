<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: AdminService.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 01:47:00
 */

namespace App\Services;

use App\Models\Area;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;

class AdminService
{
    /**
     * 判断是否是管理员
     * @author Li Tao
     * @param $user
     * @param $role
     * @return bool
     */
    public static function isAdmin($user, $role)
    {
        if (User::isAdmin($user) && Role::isAdmin($role)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 地区
     * @author Li Tao
     */
    public static function listAreaMap()
    {
        $areaList = Area::all()
            ->toArray();
        $areaMap = [];
        foreach ($areaList as $index => $area) {
            if (isset($area['parent_id']) && $area['parent_id'] == 0) {
                unset($areaList[$index]);
            }
        }
        foreach ($areaList as $index => $area) {
            if (isset($area['level']) && $area['level'] == 1 && isset($area['sort'])) {
                $areaMap[] = $area;
                unset($areaList[$index]);
            }
        }
        foreach ($areaMap as $index => $map) {
            $parentId = isset($map['id']) ? $map['id'] : 0;
            foreach ($areaList as $i => $area) {
                if (isset($area['parent_id']) && $area['parent_id'] == $parentId) {
                    $areaMap[$index]['sub_area'][] = $area;
                    unset($areaList[$i]);
                }
            }
        }
        return $areaMap;
    }

    public static function listDepartment()
    {
        $departmentList = Department::listDepartment();
        return $departmentList;
    }

}