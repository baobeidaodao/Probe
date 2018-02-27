<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Report.php
 * Author  : Li Tao
 * DateTime: 2018-02-26 12:53:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'mysql';
    protected $table = 'report';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'statistics_id',
        'ip',
        'operator_id',
        'operator',
        'province_id',
        'province',
        'probe_type',
        'date',
    ];

    public function statistics()
    {
        return $this->belongsTo('App\Models\Statistics', 'statistics_id', 'id');
    }

    public static function countReport($statisticsId)
    {
        $count = (new Report)->where('statistics_id', '=', $statisticsId)
            ->count();
        return $count;
    }

    public static function listReport($search = [], $page = 1, $size = 10)
    {
        $db = (new Report)->join('statistics', 'report.statistics_id', '=', 'statistics.id')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['uuid']) && !empty($search['uuid'])) {
                    $query->where('statistics.uuid', '=', $search['uuid']);
                }
                if (isset($search) && isset($search['ip']) && !empty($search['ip'])) {
                    $query->where('report.ip', '=', $search['ip']);
                }
                if (isset($search) && isset($search['province_id']) && !empty($search['province_id'])) {
                    $query->where('statistics.province_id', '=', $search['province_id']);
                }
                if (isset($search) && isset($search['city_id']) && !empty($search['city_id'])) {
                    $query->where('statistics.city_id', '=', $search['city_id']);
                }
                if (isset($search) && isset($search['operator_id']) && !empty($search['operator_id'])) {
                    $query->where('statistics.operator_id', '=', $search['operator_id']);
                }
                if (isset($search) && isset($search['start_date']) && !empty($search['start_date'])) {
                    $query->where('report.date', '>=', $search['start_date']);
                }
                if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
                    $query->where('report.date', '<=', $search['end_date']);
                }
            });
        $count = $db->count();
        $reportList = $db->orderBy('statistics.report_count', 'asc')
            ->orderBy('report.id', 'desc')
            ->forPage($page, $size)
            ->select([
                'report.id as report_id',
                'report.ip as ip',
                'report.operator_id as report_operator_id',
                'report.operator as report_operator',
                'report.province_id as report_province_id',
                'report.province as report_province',
                'report.probe_type as probe_type',
                'report.date as report_date',
                'statistics.*'
            ])
            ->get()
            ->toArray();
        $data = [];
        $data['count'] = $count;
        $data['reportList'] = $reportList;
        return $data;
    }

    public static function listReportForUDisk($search = [], $page = 1, $size = 10)
    {
        $db = (new UDisk)
            ->leftJoin('statistics', 'u_disk.uuid', '=', 'statistics.uuid')
            ->leftJoin('report', 'report.statistics_id', '=', 'statistics.id')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['uuid']) && !empty($search['uuid'])) {
                    $query->where('statistics.uuid', '=', $search['uuid']);
                }
                if (isset($search) && isset($search['ip']) && !empty($search['ip'])) {
                    $query->where('report.ip', '=', $search['ip']);
                }
                if (isset($search) && isset($search['province_id']) && !empty($search['province_id'])) {
                    $query->where('statistics.province_id', '=', $search['province_id']);
                }
                if (isset($search) && isset($search['city_id']) && !empty($search['city_id'])) {
                    $query->where('statistics.city_id', '=', $search['city_id']);
                }
                if (isset($search) && isset($search['operator_id']) && !empty($search['operator_id'])) {
                    $query->where('statistics.operator_id', '=', $search['operator_id']);
                }
                if (isset($search) && isset($search['start_date']) && !empty($search['start_date'])) {
                    $query->where('report.date', '>=', $search['start_date']);
                }
                if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
                    $query->where('report.date', '<=', $search['end_date']);
                }
            });
        $count = $db->count();
        $reportList = $db->orderBy('statistics.report_count', 'asc')
            ->orderBy('report.id', 'desc')
            ->forPage($page, $size)
            ->select([
                'report.id as report_id',
                'report.ip as ip',
                'report.operator_id as report_operator_id',
                'report.operator as report_operator',
                'report.province_id as report_province_id',
                'report.province as report_province',
                'report.probe_type as probe_type',
                'report.date as report_date',
                'statistics.*',
                'u_disk.uuid as uuid',
            ])
            ->get()
            ->toArray();
        $data = [];
        $data['count'] = $count;
        $data['reportList'] = $reportList;
        return $data;
    }
}