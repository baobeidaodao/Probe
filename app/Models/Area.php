<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Area.php
 * Author  : Li Tao
 * DateTime: 2018-02-21 11:59:00
 */

namespace App\Models;

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

}