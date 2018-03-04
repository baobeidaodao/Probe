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
use App\Models\UserLevel;
use Illuminate\Support\Facades\Auth;

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
        $user = $user = Auth::user();
        $areaLevel = Area::LEVEL_COUNTRY;
        if (isset($user) && !empty($user) && isset($user->level) && !empty($user->level)) {
            $userLevel = isset($user->level) ? $user->level : UserLevel::LEVEL_ADMIN;
            switch ($userLevel) {
                case UserLevel::LEVEL_ADMIN:
                    $areaLevel = Area::LEVEL_COUNTRY;
                    break;
                case UserLevel::LEVEL_GROUP_MANAGER:
                    $areaLevel = Area::LEVEL_COUNTRY;
                    break;
                case UserLevel::LEVEL_PROVINCIAL_MANAGER:
                    $areaLevel = Area::LEVEL_PROVINCE;
                    break;
                case UserLevel::LEVEL_MUNICIPAL_MANAGER:
                    $areaLevel = Area::LEVEL_CITY;
                    break;
                case UserLevel::LEVEL_TESTER:
                    $areaLevel = Area::LEVEL_COUNTY;
                    break;
                default:
                    $areaLevel = Area::LEVEL_COUNTRY;
                    break;
            }
        }
        $areaId = isset($user->area_id) && !empty($user->area_id) ? $user->area_id : Area::COUNTRY_ID;
        $area = (new Area)->findOrFail($areaId);
        // $areaList = Area::all()->toArray();
        $areaList = (new Area)->where('level', '>=', $areaLevel)
            ->where(function ($query) use ($areaLevel, $area) {
                if ($areaLevel >= Area::LEVEL_PROVINCE) {
                    if (isset($area) && isset($area->level) && isset($area->id) && isset($area->parent_id)) {
                        if ($area->level == 2) {
                            $query->where('area.id', '=', $area->id)
                                ->orWhere('area.id', '=', $area->parent_id);
                        } else if ($area->level == 1) {
                            $query->where('area.id', '=', $area->id)
                                ->orWhere('area.parent_id', '=', $area->id);
                        }
                    }
                }
            })
            ->get()
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

    public static function listAreaMapForUser($user = null)
    {
        if (!isset($user)) {
            $user = $user = Auth::user();
        }
        $areaLevel = Area::LEVEL_COUNTRY;
        if (isset($user) && !empty($user) && isset($user->level) && !empty($user->level)) {
            $userLevel = isset($user->level) ? $user->level : UserLevel::LEVEL_ADMIN;
            switch ($userLevel) {
                case UserLevel::LEVEL_ADMIN:
                    $areaLevel = Area::LEVEL_COUNTRY;
                    break;
                case UserLevel::LEVEL_GROUP_MANAGER:
                    $areaLevel = Area::LEVEL_COUNTRY;
                    break;
                case UserLevel::LEVEL_PROVINCIAL_MANAGER:
                    $areaLevel = Area::LEVEL_PROVINCE;
                    break;
                case UserLevel::LEVEL_MUNICIPAL_MANAGER:
                    $areaLevel = Area::LEVEL_CITY;
                    break;
                case UserLevel::LEVEL_TESTER:
                    $areaLevel = Area::LEVEL_COUNTY;
                    break;
                default:
                    $areaLevel = Area::LEVEL_COUNTRY;
                    break;
            }
        }
        $areaId = isset($user->area_id) && !empty($user->area_id) ? $user->area_id : Area::COUNTRY_ID;
        $area = (new Area)->findOrFail($areaId);
        $areaList = (new Area)->where('level', '>=', $areaLevel)
            ->where(function ($query) use ($areaLevel, $area) {
                if ($areaLevel >= Area::LEVEL_PROVINCE) {
                    if (isset($area) && isset($area->level) && isset($area->id) && isset($area->parent_id)) {
                        if ($area->level == 2) {
                            $query->where('area.id', '=', $area->id)
                                ->orWhere('area.id', '=', $area->parent_id);
                        } else if ($area->level == 1) {
                            $query->where('area.id', '=', $area->id)
                                ->orWhere('area.parent_id', '=', $area->id);
                        }
                    }
                }
            })
            ->get()
            ->toArray();
        $allAreaList = (new Area)::all()->toArray();
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
        if (empty($areaMap)) {
            foreach ($areaList as $index => $area) {
                if (isset($area['level']) && $area['level'] == 2 && isset($area['sort'])) {
                    foreach ($allAreaList as $key => $value) {
                        if ($value['id'] == $area['parent_id']) {
                            $areaMap[] = $value;
                            break;
                        }
                    }
                }
            }
        }
        foreach ($areaMap as $index => $map) {
            $parentId = isset($map['id']) ? $map['id'] : 0;
            foreach ($allAreaList as $i => $area) {
                if (isset($area['parent_id']) && $area['parent_id'] == $parentId) {
                    if ($areaLevel == Area::LEVEL_CITY) {
                        if ($user->area_id == $area['id']) {
                            $areaMap[$index]['sub_area'][] = $area;
                        }
                    } else {
                        $areaMap[$index]['sub_area'][] = $area;
                    }
                    unset($allAreaList[$i]);
                }
            }
        }
        return $areaMap;
    }

}