<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Statistics.php
 * Author  : Li Tao
 * DateTime: 2018-02-26 05:43:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}