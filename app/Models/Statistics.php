<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Statistics.php
 * Author  : Li Tao
 * DateTime: 2018-02-26 05:43:00
 */

namespace App\Models;

use App\Services\AppService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Statistics extends Model
{
    protected $connection = 'mysql';
    protected $table = 'statistics';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'u_disk_id',
        'uuid',
        'user_id',
        'user_name',
        'user_phone',
        'user_email',
        'user_department_id',
        'user_department',
        'province_id',
        'province',
        'city_id',
        'city',
        'operator_id',
        'operator',
        'report_count',
        'date',
    ];

    public static function summaryStatistics($search = [], $page = 1, $size = 10)
    {
        $select = ' ' . 'statistics.id, 
        statistics.u_disk_id,
        statistics.uuid,
        statistics.user_id,
        statistics.id,
        statistics.user_name,
        statistics.user_phone,
        statistics.user_email,
        statistics.user_department_id,
        statistics.user_department,
        statistics.province_id,
        statistics.province,
        statistics.city_id,
        statistics.city,
        statistics.operator_id,
        statistics.operator,
        sum(statistics.report_count) as report_count,
        statistics.date' . ' ';
        $where = ' ' . 'true' . ' ';
        if (isset($search) && isset($search['uuid']) && !empty($search['uuid'])) {
            $where .= ' ' . 'and uuid = \'' . $search['uuid'] . '\' ';
        }
        if (isset($search) && isset($search['province_id']) && !empty($search['province_id'])) {
            $where .= ' ' . 'and province_id = ' . $search['province_id'] . ' ';
        }
        if (isset($search) && isset($search['city_id']) && !empty($search['city_id'])) {
            $where .= ' ' . 'and city_id = ' . $search['city_id'] . ' ';
        }
        if (isset($search) && isset($search['operator_id']) && !empty($search['operator_id'])) {
            $where .= ' ' . 'and operator_id = ' . $search['operator_id'] . ' ';
        }
        if (isset($search) && isset($search['start_date']) && !empty($search['start_date'])) {
            $where .= ' ' . 'and date >= \'' . $search['start_date'] . '\' ';
        }
        if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
            $where .= ' ' . 'and date <= \'' . $search['end_date'] . '\' ';
        }
        $sql = ' SELECT ' . $select . ' FROM statistics WHERE ' . $where . ' GROUP BY uuid, user_id ORDER BY report_count ASC, date DESC ';
        $sql = str_replace(["\r\n", "\r", "\n"], ' ', $sql);
        DB::statement('set @@sql_mode=\'\'');
        $statisticsList = DB::select($sql);
        $statisticsList = json_decode(json_encode($statisticsList), true);
        $count = count($statisticsList);
        $statisticsList = array_slice($statisticsList, ($page - 1) * $size, $size);
        foreach ($statisticsList as $index => $statistics) {
            $reportList = (new Report)->join('statistics', 'report.statistics_id', '=', 'statistics.id')
                ->where('statistics.uuid', '=', $statistics['uuid'])
                ->where(function ($query) use ($search) {
                    if (isset($search) && isset($search['start_date']) && !empty($search['start_date'])) {
                        $query->where('report.date', '>=', $search['start_date']);
                    }
                    if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
                        $query->where('report.date', '<=', $search['end_date']);
                    }
                })
                ->select([
                    'report.*',
                ])
                ->get()
                ->toArray();
            $statisticsList[$index]['report'] = $reportList;
        }
        $data = [];
        $data['count'] = $count;
        $data['statisticsList'] = $statisticsList;
        return $data;
    }

    /**
     * @author Li Tao
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function report()
    {
        return $this->hasMany('App\Models\Report', 'statistics_id', 'id');
    }

    /**
     * @author Li Tao
     * @param array $search
     * @param int $page
     * @param int $size
     * @return array
     */
    public static function listStatistics($search = [], $page = 1, $size = 10)
    {
        $db = (new Statistics)->with('report')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['uuid']) && !empty($search['uuid'])) {
                    $query->where('uuid', '=', $search['uuid']);
                }
                if (isset($search) && isset($search['province_id']) && !empty($search['province_id'])) {
                    $query->where('province_id', '=', $search['province_id']);
                }
                if (isset($search) && isset($search['city_id']) && !empty($search['city_id'])) {
                    $query->where('city_id', '=', $search['city_id']);
                }
                if (isset($search) && isset($search['operator_id']) && !empty($search['operator_id'])) {
                    $query->where('operator_id', '=', $search['operator_id']);
                }
                if (isset($search) && isset($search['start_date']) && !empty($search['start_date'])) {
                    $query->where('date', '>=', $search['start_date']);
                }
                if (isset($search) && isset($search['end_date']) && !empty($search['end_date'])) {
                    $query->where('date', '<=', $search['end_date']);
                }
            });
        $count = $db->count();
        $statisticsList = $db->orderBy('report_count', 'asc')
            ->orderBy('id', 'desc')
            ->forPage($page, $size)
            ->get()
            ->toArray();
        $data = [];
        $data['count'] = $count;
        $data['statisticsList'] = $statisticsList;
        return $data;
    }

    public static function listStatisticsForUDisk($search = [], $page = 1, $size = 10)
    {
        $db = (new UDisk)
            ->leftJoin('statistics', 'u_disk.uuid', '=', 'statistics.uuid')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['uuid']) && !empty($search['uuid'])) {
                    $query->where('u_disk.uuid', '=', $search['uuid']);
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
            });
        $count = $db->count();
        $statisticsList = $db->orderBy('date', 'desc')
            ->orderBy('report_count', 'asc')
            ->orderBy('id', 'desc')
            ->forPage($page, $size)
            ->select([
                'statistics.*',
                'u_disk.uuid as uuid',
            ])
            ->get()
            ->toArray();
        foreach ($statisticsList as $index => $statistics) {
            $statisticsId = $statistics['id'];
            $reportList = (new Report)->where('statistics_id', '=', $statisticsId)
                ->get()
                ->toArray();
            $statisticsList[$index]['report'] = $reportList;
        }
        $data = [];
        $data['count'] = $count;
        $data['statisticsList'] = $statisticsList;
        return $data;
    }

}