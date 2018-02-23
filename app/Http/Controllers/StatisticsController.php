<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: StatisticsController.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 19:14:00
 */

namespace App\Http\Controllers;

class StatisticsController extends Controller
{
    public static function index()
    {
        $data = [];
        $data['active'] = 'statistics';
        return view('admin.statistics.index', $data);
    }
}