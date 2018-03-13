<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: ReportConfig.php
 * Author  : Li Tao
 * DateTime: 2018-03-13 11:14:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportConfig extends Model
{
    protected $connection = 'mysql';
    protected $table = 'report_config';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'option',
        'value',
    ];

    public static function operatorIdLevel()
    {
        $operatorIdLevel1 = (new ReportConfig)
            ->where('option', '=', 'operator_id_level_1')
            ->select('value')
            ->first();
        $operatorIdLevel2 = (new ReportConfig)
            ->where('option', '=', 'operator_id_level_2')
            ->select('value')
            ->first();
        $operatorIdLevel = [];
        $operatorIdLevel['operatorIdLevel1'] = isset($operatorIdLevel1->value) && !empty($operatorIdLevel1->value) ? $operatorIdLevel1->value : 0;
        $operatorIdLevel['operatorIdLevel2'] = isset($operatorIdLevel2->value) && !empty($operatorIdLevel2->value) ? $operatorIdLevel2->value : 0;
        return $operatorIdLevel;
    }
}