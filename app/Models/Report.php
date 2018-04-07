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
use Illuminate\Support\Facades\Auth;

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
            ->where(function ($query) {
                //$area = Area::areaForUser();
                //$query->whereIn('statistics.province_id', $area['areaIdList'])
                //    ->orWhereIn('statistics.city_id', $area['areaIdList']);
            })
            ->where(function ($query) {
                if (Auth::user()->level > UserLevel::LEVEL_GROUP_MANAGER) {
                    $userIdList = User::listUserIdForAuth();
                    $query->whereIn('statistics.user_id', $userIdList);
                }
            })
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
        $reportList = $db->orderBy('report.date', 'desc')
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

    public static function listReportForProvince($search = [])
    {
        $reportList = (new Area)->leftJoin('report', 'area.id', '=', 'report.province_id')
            ->leftJoin('statistics', 'report.statistics_id', '=', 'statistics.id')
            ->whereNotNull('report.ip')
            ->where('area.level', '=', Area::LEVEL_PROVINCE)
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['probe_type']) && !empty($search['probe_type'])) {
                    $query->where('report.probe_type', '=', $search['probe_type']);
                }
                if (isset($search) && isset($search['ip']) && !empty($search['ip'])) {
                    $query->where('report.ip', '=', $search['ip']);
                }
                if (isset($search) && isset($search['report_province_id']) && !empty($search['report_province_id'])) {
                    $query->where('report.province_id', '=', $search['report_province_id']);
                }
                if (isset($search) && isset($search['report_operator_id']) && !empty($search['report_operator_id'])) {
                    $query->where('report.operator_id', '=', $search['report_operator_id']);
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
                    $query->where('statistics.date', '>=', $search['start_date']);
                }
                if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
                    $query->where('statistics.date', '<=', $search['end_date']);
                }
            })
            ->orderBy('area.id', 'asc')
            ->orderBy('report.date', 'desc')
            ->select([
                'statistics.id',
                'statistics.uuid',
                'statistics.user_id',
                'statistics.user_name',
                'statistics.user_phone',
                'statistics.user_email',
                'statistics.user_department_id',
                'statistics.user_department',
                'statistics.province_id',
                'statistics.province',
                'statistics.city_id',
                'statistics.city',
                'statistics.operator_id',
                'statistics.operator',
                'statistics.report_count',
                'statistics.date',
                'report.id as report_id',
                'report.ip',
                'report.operator_id as report_operator_id',
                'report.operator as report_operator',
                'report.province_id as report_province_id',
                'report.province as report_province',
                'report.probe_type',
                'report.date as report_date',
            ])
            ->get()
            ->toArray();
        return $reportList;
    }

    public static function countReportForGroup($search = [])
    {
        $count = (new Report)->leftJoin('statistics', 'report.statistics_id', '=', 'statistics.id')
            ->whereNotNull('report.ip')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['probe_type']) && !empty($search['probe_type'])) {
                    $query->where('report.probe_type', '=', $search['probe_type']);
                }
                if (isset($search) && isset($search['ip']) && !empty($search['ip'])) {
                    $query->where('report.ip', '=', $search['ip']);
                }
                if (isset($search) && isset($search['report_province_id']) && !empty($search['report_province_id'])) {
                    $query->where('report.province_id', '=', $search['report_province_id']);
                }
                if (isset($search) && isset($search['report_operator_id']) && !empty($search['report_operator_id'])) {
                    $query->where('report.operator_id', '=', $search['report_operator_id']);
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
                    $query->where('statistics.date', '>=', $search['start_date']);
                }
                if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
                    $query->where('statistics.date', '<=', $search['end_date']);
                }
            })
            ->count();
        return $count;
    }

}