<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Area.php
 * Author  : Li Tao
 * DateTime: 2018-02-21 11:59:00
 */

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $connection = 'mysql';
    protected $table = 'area';
    protected $primaryKey = 'id';
    public $timestamps = false;

    const LEVEL_COUNTRY = 0;
    const LEVEL_PROVINCE = 1;
    const LEVEL_CITY = 2;
    const LEVEL_COUNTY = 3;
    const COUNTRY_ID = 100000;

    public static function listCity()
    {
        $cityList = (new Area)->where('level', '=', self::LEVEL_CITY)
            ->get()
            ->toArray();
        return $cityList;
    }

    public static function listProvince()
    {
        $cityList = (new Area)->where('level', '=', self::LEVEL_PROVINCE)
            ->get()
            ->toArray();
        return $cityList;
    }

    public static function areaForUser($user = null)
    {
        if (!isset($user)) {
            $user = Auth::user();
        }
        $areaId = isset($user->area_id) && !empty($user->area_id) ? $user->area_id : Area::COUNTRY_ID;
        $area = (new Area)->find($areaId);
        $areaParentId = isset($area->parent_id) ? $area->parent_id : Area::COUNTRY_ID;
        $level = isset($area->level) ? $area->level : Area::LEVEL_COUNTRY;
        $provinceIdList = [];
        $cityIdList = [];
        if ($level == Area::LEVEL_COUNTRY || (isset($user->level) && ($user->level == UserLevel::LEVEL_ADMIN || $user->level == UserLevel::LEVEL_GROUP_MANAGER))) {
            $provinceIdList = (new Area)->where('level', '=', self::LEVEL_PROVINCE)
                ->select('id')
                ->get()
                ->toArray();
            $cityIdList = (new Area)->where('level', '=', self::LEVEL_CITY)
                ->select('id')
                ->get()
                ->toArray();
        } else if ($level == Area::LEVEL_PROVINCE) {
            $provinceIdList = (new Area)->where('level', '=', self::LEVEL_PROVINCE)
                ->where('id', '=', $areaId)
                ->select('id')
                ->get()
                ->toArray();
            $cityIdList = (new Area)->where('level', '=', self::LEVEL_CITY)
                ->where('parent_id', '=', $areaId)
                ->select('id')
                ->get()
                ->toArray();
        } else if ($level == Area::LEVEL_CITY) {
            /**
             * $provinceIdList = (new Area)->where('level', '=', self::LEVEL_PROVINCE)
             * ->where('id', '=', $areaParentId)
             * ->select('id')
             * ->get()
             * ->toArray();
             */
            $provinceIdList = [];
            $cityIdList = (new Area)->where('level', '=', self::LEVEL_CITY)
                ->where('id', '=', $areaId)
                ->select('id')
                ->get()
                ->toArray();
        }
        $provinceIdList = self::getIds($provinceIdList);
        $cityIdList = self::getIds($cityIdList);
        $areaIdList = array_merge($provinceIdList, $cityIdList);
        $data = [];
        $data['level'] = $level;
        $data['provinceIdList'] = $provinceIdList;
        $data['cityIdList'] = $cityIdList;
        $data['areaIdList'] = $areaIdList;
        return $data;
    }

    public static function getIds($areaIdList = [])
    {
        $idArray = [];
        foreach ($areaIdList as $areaId) {
            $idArray[] = $areaId['id'];
        }
        return $idArray;
    }
}