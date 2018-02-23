<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: DataController.php
 * Author  : Li Tao
 * DateTime: 2018-02-23 10:57:00
 */

namespace App\Http\Controllers;

class DataController extends Controller
{
    public static function index()
    {
        $data = [];
        $data['active'] = 'data';
        return view('admin.data.index', $data);
    }
}